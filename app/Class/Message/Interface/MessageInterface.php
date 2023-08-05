<?php

namespace App\Class\Message\Interface;

use App\Class\PromptHistory\PromptHistoryDTO;
use App\Core\Interfaces\DTOInterface;

interface MessageInterface extends DTOInterface
{
    public function getContent(): ?string;
    public function setContent(string|null $content): self;
    public function getSenderClass(): ?string;
    public function setSenderClass(string|null $senderClass): self;
    public function getSenderId(): ?int;
    public function setSenderId(int|null $senderId): self;
    public function getConversionId(): ?int;
    public function setConversionId(int|null $conversationId): self;
    public function getPromptHistory(): ?PromptHistoryDTO;
    public function setPromptHistory(?PromptHistoryDTO $promptHistory): self;
    public function getUserId(): ?int;
    public function setUserId(?int $userId): self;
}
