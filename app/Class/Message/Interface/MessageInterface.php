<?php

namespace App\Class\Message\Interface;

use App\Class\PromptHistory\Prompt;
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
    public function getPromptHistory(): ?Prompt;
    public function setPromptHistory(?Prompt $promptHistory): self;
    public function getUserId(): ?int;
    public function setUserId(?int $userId): self;
    public function getResult(): ?string;
    public function setResult(string|null $result): self;
    public function setLinks(?string $links): self;
    public function getLinks(): ?string;
}
