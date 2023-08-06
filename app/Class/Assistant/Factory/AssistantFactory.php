<?php

namespace App\Class\Assistant\Factory;

use App\Class\Assistant\AssistantDTO;
use App\Class\Assistant\Enum\AssistantType;
use App\Class\Assistant\Interface\AssistantInterface;
use App\Class\PromptHistory\Prompt;

class AssistantFactory
{
    public function createAssistantDTO(
        int $id = null,
        string $name = null,
        string $shortName = null,
        string $imgUrl = null,
        int $sort = 1,
        AssistantType $type = null,
        bool $public = false,
        string $prompt = null,
    ): AssistantInterface
    {
        $assistantDTO = new AssistantDTO();
        $assistantDTO->setId($id ?? null);
        $assistantDTO->setName($name ?? null);
        $assistantDTO->setShortName($shortName ?? null);
        $assistantDTO->setImgUrl($imgUrl ?? null);
        $assistantDTO->setSort($sort);
        $assistantDTO->setType($type ?? null);
        $assistantDTO->setPublic($public ?? false);
        $assistantDTO->setPromptHistory(new Prompt($prompt, null));
        return $assistantDTO;
    }
}
