<?php

namespace App\Class\Assistant\Helper;

use App\Class\Assistant\AssistantDTO;
use App\Class\Assistant\Factory\AssistantFactory;
use App\Class\Assistant\Interface\AssistantInterface;
use App\Class\PromptHistory\Prompt;
use App\Core\Abstract\Mapper;
use App\Core\Interfaces\DTOInterface;
use App\Models\Assistant;
use Illuminate\Database\Eloquent\Model;

class AssistantMapper extends Mapper
{
    public function __construct(
        private readonly AssistantFactory $assistantFactory,
    )
    {
    }

    public function mapToDTO(Assistant|Model $model): DTOInterface
    {
        return $this->assistantFactory->createAssistantDTO(
            id: $model->id,
            name: $model->name,
            shortName: $model->short_name,
            imgUrl: $model->img_url,
            sort: $model->sort,
            type: $model->type,
            public: $model->public,
            prompt: $model->prompt,
            memoryCollection: $model->memory_collection
        );
    }

    public function mapToModel(AssistantInterface|DTOInterface $dtoClass): Model
    {
        $assistant = new Assistant();
        $assistant->id = $dtoClass->getId() ?? null;
        $assistant->name = $dtoClass->getName();
        $assistant->short_name = $dtoClass->getShortName();
        $assistant->img_url = $dtoClass->getImgUrl();
        $assistant->sort = $dtoClass->getSort();
        $assistant->type = $dtoClass->getType();
        $assistant->public = $dtoClass->getPublic();
        $assistant->prompt = $dtoClass->getPromptHistory()->getPrompt();
        $assistant->memory_collection = $dtoClass->getMemoryCollection();
        return $assistant;
    }
}
