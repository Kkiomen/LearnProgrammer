<?php

namespace App\Services;

use App\Class\Assistant\Interface\AssistantInterface;
use App\Class\Assistant\Repository\AssistantRepository;
use App\Models\Assistant;
use Illuminate\Support\Collection;

class AssistantService
{

    public function __construct(
        private readonly AssistantRepository $assistantRepository
    )
    {
    }

    public function allAssistants(): Collection|array
    {
        return $this->assistantRepository->getAssistants();
    }

    public function getById($assistantId): AssistantInterface|null
    {
        return $this->assistantRepository->getAssistantById($assistantId);
    }

    public function getAssistantMemory(AssistantInterface $assistant): \Illuminate\Database\Eloquent\Collection
    {
        return $this->assistantRepository->getLongTermMemoryAssistant($assistant);
    }

    public function save(AssistantInterface $assistant): bool
    {
        return $this->assistantRepository->save($assistant);
    }
}
