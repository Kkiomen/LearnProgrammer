<?php

namespace App\Class;

use App\Api\OpenAiApi;
use App\Api\Qdrant\PointStruct;
use App\Api\Qdrant\Qdrant;
use App\Api\Qdrant\Search\SearchRequest;
use App\Api\Qdrant\Vector\VectorText;
use App\Models\LongTermMemoryContent;
use App\Models\Message;

class LongTermMemoryQdrant
{
    private Qdrant $qdrant;
    private OpenAiApi $openAiApi;

    public function __construct(Qdrant $qdrant, OpenAiApi $openAiApi)
    {
        $this->qdrant = $qdrant;
        $this->openAiApi = $openAiApi;
    }

    /**
     * Saves the given content as a long-term memory.
     * @param string $content The content to be saved.
     * @param Message|null $message The optional message related to the content.
     * @return bool Returns true if the memory was successfully saved, false otherwise.
     * @throws \Exception
     */
    public function save(string $content, ?Message $message = null): bool
    {
        $content = $this->getContentFromMessage($content, $message);
        $tags = $this->openAiApi->makeTags($content);
        $longTerm = $this->createLongTermMemory($this->getIdFromMessage($message), $content, $tags);

        if ($this->qdrant->addVector(
            new PointStruct(
                id: $longTerm->id,
                vector: new VectorText(
                    openAiApi: $this->openAiApi,
                    text: $longTerm->content
                ),
                nameCollection: 'memory'
            )
        )) {
            $this->markLongTermMemoryAsSynced($longTerm);
            return true;
        }

        return false;
    }

    /**
     * Retrieves the long-term memory that best matches the given content.
     * @param string $content The content to be used for matching.
     * @param Message|null $message The optional message related to the content.
     * @return array|null Returns an array with the best matching long-term memory entities, or null if no match is found.
     * @throws \Exception
     */
    public function getMemory(string $content, ?Message $message = null){
        $content = $this->getContentFromMessage($content, $message);
        $result = $this->qdrant->search(new SearchRequest(
            vector: new VectorText(
                openAiApi: $this->openAiApi,
                text: $content
            ),
            nameCollection: 'memory'
        ));
        return $this->filterLongTermMatches($result);
    }

    private function filterLongTermMatches(?array $matches): array
    {
        if(empty($matches)){
            return [];
        }

        $result = array();
        foreach ($matches as $match) {
            if ($match['score'] > 0.7) {
                $longTerm = LongTermMemoryContent::where('id', $match['id'])->first();
                if($longTerm){
                    $result[] = $longTerm->content;
                }
            }
        }
        return $result;
    }

    /**
     * Returns the message content if available, otherwise returns the provided content.
     *
     * @param string $content The fallback content to use if message content is not available.
     * @param Message|null $message The message to extract content from.
     * @return string The message content if available, otherwise returns the provided content.
     */
    private function getContentFromMessage(string $content, ?Message $message): string
    {
        return (!is_null($message) && $message->message) ? $message->message : $content;
    }

    /**
     * Creates a new long-term memory content record in the database.
     *
     * @param int $id The ID of the message associated with the long-term memory content.
     * @param string $content The content of the long-term memory.
     * @param string $tags The tags associated with the long-term memory.
     * @return LongTermMemoryContent The created long-term memory content record.
     */
    private function createLongTermMemory(int $id, string $content, string $tags): LongTermMemoryContent
    {
        $longTerm = new LongTermMemoryContent();
        $longTerm->message_id = $id;
        $longTerm->content = $content;
        $longTerm->tags = $tags;
        $longTerm->save();
        return $longTerm;
    }

    /**
     * Returns the message ID if available, otherwise returns .
     *
     * @param Message|null $message The message to extract ID from.
     * @return int The message ID if available, otherwise returns .
     */
    private function getIdFromMessage(?Message $message): int
    {
        return (!is_null($message) && $message->id) ? $message->id : 0;
    }

    /**
     * Marks a given long-term memory content record as synced.
     *
     * @param LongTermMemoryContent $longTerm The long-term memory content record to mark as synced.
     * @return void
     */
    private function markLongTermMemoryAsSynced(LongTermMemoryContent $longTerm): void
    {
        $longTerm->sync = true;
        $longTerm->save();
    }
}
