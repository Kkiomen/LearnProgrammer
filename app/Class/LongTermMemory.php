<?php

namespace App\Class;

use App\Api\OpenAiApi;
use App\Api\PineconeApi;
use App\Helpers\ApiHelper;
use App\Models\LongTermMemoryContent;
use App\Models\Message;

class LongTermMemory
{
    private PineconeApi $pineconeApi;
    private OpenAiApi $openAiApi;

    public function __construct(PineconeApi $pineconeApi, OpenAiApi $openAiApi)
    {
        $this->pineconeApi = $pineconeApi;
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
        $this->pineconeApi->setApiKey(ApiHelper::getPineconeApiKey());
        $content = $this->getContentFromMessage($content, $message);
        $id = $this->getIdFromMessage($message);
        $tags = $this->openAiApi->makeTags($content);
        $longTerm = $this->createLongTermMemory($id, $content, $tags);
        $data = $this->createPineconeData($longTerm->id, $content, $tags);
        if ($this->pineconeApi->upsert($data)) {
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
        $this->pineconeApi->setApiKey(ApiHelper::getPineconeApiKey());
        $content = $this->getContentFromMessage($content, $message);
        $vectorsEmbedding = $this->openAiApi->embedding($content);
        $count = 7;
        $data = [
            'topK' => $count,
            'vector' => $vectorsEmbedding,
            'includeMetadata' => true
        ];

        $response = $this->pineconeApi->get($data);
        if(is_array($response)){
            return $this->filterLongTermMatches($response['matches']);
        }

        return null;
    }

    private function filterLongTermMatches(?array $matches): ?array
    {
        if(is_null($matches)){
            return null;
        }

        $result = array();
        foreach ($matches as $match) {
            if ($match['score'] > 0.8) {
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
     * Creates an array of Pinecone data for a given message ID, content, and tags.
     *
     * @param int $id The ID of the message.
     * @param string $content The content to be embedded as a vector.
     * @param string $tags The tags to associate with the vector.
     * @return array The Pinecone data array.
     */
    private function createPineconeData(int $id, string $content, string $tags): array
    {
        return [
            'vectors' => [
                'id' => (string) $id,
                'values' => $this->openAiApi->embedding($content),
                'metadata' => [
                    'id' => $id,
                    'tags' => $tags
                ]
            ]
        ];
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
