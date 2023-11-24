<?php

namespace App\Class\Conversation\Interface;

use App\Class\Conversation\Enum\ConversationStatus;
use App\Core\Interfaces\DTOInterface;

interface ConversationInterface extends DTOInterface
{
    public function getAssistantId(): ?int;
    public function setAssistantId(?int $assistantId): self;
    public function getConsultantId(): ?int;
    public function setConsultantId(?int $consultant_id): self;
    public function getSessionHash(): ?string;
    public function setSessionHash(?string $sessionHash): self;
    public function getTitle(): ?string;
    public function setTitle(?string $title): self;
    public function isActive(): bool;
    public function setActive(bool $active): self;
    public function getConversationStatus(): ConversationStatus;
    public function setConversationStatus(ConversationStatus $conversationStatus): self;
}
