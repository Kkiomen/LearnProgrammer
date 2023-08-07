<?php

namespace App\Class\Assistant\Repository;

use App\Class\Assistant\AssistantDTO;
use App\Class\Assistant\Helper\AssistantMapper;
use App\Class\Assistant\Interface\AssistantInterface;
use App\Class\LongTermMemory;
use App\Core\Interfaces\DTOInterface;
use App\Models\Assistant;
use App\Models\LongTermMemoryContent;
use Illuminate\Support\Collection;

class AssistantRepository
{


    public function __construct(
        private readonly AssistantMapper $assistantMapper,
    )
    {
    }
    public function getAssistants(): Collection|array
    {
        $assistants = Assistant::get();
        if($assistants === null){
            return [];
        }

        return $this->assistantMapper->mapCollectionToDTO($assistants);
    }

    public function getAssistantById(int $id, bool $toDto = true): AssistantInterface|Assistant|null
    {
        $assistant = Assistant::find($id);
        if(is_null($assistant)){
            return null;
        }

        if($toDto){
            return $this->assistantMapper->mapToDTO($assistant);
        }

       return $assistant;
    }

    public function getLongTermMemoryAssistant(AssistantInterface $assistant): \Illuminate\Database\Eloquent\Collection
    {
        return LongTermMemoryContent::where('assistant_id', $assistant->getId())->get();
    }

    public function save(AssistantInterface &$assistant): bool
    {
        $assistantModel = $this->assistantMapper->mapToModel($assistant);
        $existingAssistantModel = Assistant::find($assistantModel->id);

        if($existingAssistantModel){
            // Update existing conversation
            $existingAssistantModel->update($assistantModel->getAttributes());
            return true;
        } else {
            // Save new message
            if ($assistantModel->save()) {
                return true;
            }
        }

        return false;
    }
}
