<?php

namespace App\Class\Assistant\Repository;

use App\Class\Assistant\AssistantDTO;
use App\Class\Assistant\Helper\AssistantMapper;
use App\Core\Interfaces\DTOInterface;
use App\Models\Assistant;

class AssistantRepository
{


    public function __construct(
        private readonly AssistantMapper $assistantMapper,
    )
    {
    }

    public function getAssistantById(int|null $id, bool $toDto = true): Assistant|DTOInterface|null
    {
        if($id === null){
            return null;
        }

        $entity = Assistant::find($id);
        if($toDto){
            return $this->assistantMapper->mapToDTO($entity);
        }

        return $entity;
    }
}
