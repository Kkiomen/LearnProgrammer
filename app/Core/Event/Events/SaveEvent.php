<?php

namespace App\Core\Event\Events;

use App\Class\Assistant\Repository\AssistantRepository;
use App\Class\LongTermMemoryQdrant;
use App\Core\Abstract\Event;
use App\Core\Dto\EventData;
use App\Core\Dto\EventResponseDto;
use App\Models\LongTermMemoryContent;

class SaveEvent extends Event
{
    protected ?string $name = 'save';
    protected ?string $description = 'save/remember information in memory';
    protected array $triggers = ['zapisz', 'zapamiętaj', 'zapamietaj', 'save', 'store', 'remember'];


    public function __construct(
        protected readonly AssistantRepository $assistantRepository)
    {
    }

    public function handle(EventData $eventData): EventResponseDto
    {
        /**
         * @var LongTermMemoryQdrant $longTermMemoryQdrant
         */
        $longTermMemoryQdrant = app(LongTermMemoryQdrant::class);
        $assistant = $this->assistantRepository->getAssistantById($eventData->getAssistantId());


        if($longTermMemoryQdrant->save($eventData->getContent(), null, $assistant->getMemoryCollection())){
            $longTermMemory = LongTermMemoryContent::where('content', $eventData->getContent())->first();
            $eventData->setContent('Tell the user that their information has been saved. Use the language the user wrote in. Give emoticon about save.');
            $longTermMemory->assistant_id = $eventData->getAssistantId();
            $longTermMemory->type = 'TEXT';
            $longTermMemory->save();
        }


        $response = new EventResponseDto($this->getName());
        $response->setContent($eventData->getContent())
            ->setChangedContent(true);
        return $response;
    }
}
