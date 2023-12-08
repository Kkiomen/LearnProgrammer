<?php

namespace App\CoreAssistant\Domain\Message;

use App\CoreAssistant\Core\Domain\Abstract\Entity;
use App\CoreAssistant\Core\Patterns\Builder\BuilderEntity;

class MessageBuilder implements BuilderEntity
{
    private Message $message;

    public function __construct()
    {
        $this->message = new Message();
    }

    public function setId(?int $id): self
    {
        $this->message->setId($id);

        return $this;
    }

    public function setUserId(?int $userId): self
    {
        $this->message->setUserId($userId);

        return $this;
    }

    public function setConversationId(?int $conversationId): self
    {
        $this->message->setConversationId($conversationId);

        return $this;
    }

    public function setUserMessage(?string $userMessage): self
    {
        $this->message->setUserMessage($userMessage);

        return $this;
    }

    public function setSenderClass(?string $senderClass): self
    {
        $this->message->setSenderClass($senderClass);

        return $this;
    }

    public function setSenderId(?int $senderId): self
    {
        $this->message->setSenderId($senderId);

        return $this;
    }

    public function setPrompt(?string $prompt): self
    {
        $this->message->setPrompt($prompt);

        return $this;
    }

    public function setSystem(?string $system): self
    {
        $this->message->setSystem($system);

        return $this;
    }

    public function setResult(?string $result): self
    {
        $this->message->setResult($result);

        return $this;
    }

    public function setSteps(?string $steps): self
    {
        $this->message->setSteps($steps);

        return $this;
    }

    public function setQueries(?string $queries): self
    {
        $this->message->setSteps($queries);

        return $this;
    }

    public function setTable(?string $table): self
    {
        $this->message->setTable($table);

        return $this;
    }

    public function setLinks(?string $links): self
    {
        $this->message->setLinks($links);

        return $this;
    }

    public function setCreatedAt(?\DateTime $createdAt): self
    {
        $this->message->setCreatedAt($createdAt);

        return $this;
    }

    public function setUpdatedAt(?\DateTime $updateAt): self
    {
        $this->message->setUpdatedAt($updateAt);

        return $this;
    }

    public function reset(): void
    {
        $this->message = new Message();
    }

    public function build(): Entity
    {
        return $this->message;
    }
}
