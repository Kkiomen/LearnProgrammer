<?php

namespace App\Class\Message;

use App\Class\Message\Interface\MessageInterface;

final class MessageDTO implements MessageInterface
{
    /**
     * @var int|null The ID of the message.
     */
    private ?int $id;

    /**
     * @var string|null The content of the message.
     */
    private ?string $content;

    /**
     * @var string|null The class of the sender.
     */
    private ?string $senderClass;

    /**
     * @var int|null The ID of the sender.
     */
    private ?int $senderId;

    /**
     * Get the ID of the message.
     *
     * @return int|null The ID of the message.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the ID of the message.
     *
     * @param int|null $id The ID to set for the message.
     * @return self Returns an instance of the MessageDTO.
     */
    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get the content of the message.
     *
     * @return string|null The content of the message.
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Set the content of the message.
     *
     * @param string|null $content The content to set for the message.
     * @return self Returns an instance of the MessageDTO.
     */
    public function setContent(?string $content): self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Get the class of the sender.
     *
     * @return string|null The class of the sender.
     */
    public function getSenderClass(): ?string
    {
        return $this->senderClass;
    }

    /**
     * Set the class of the sender.
     *
     * @param string|null $senderClass The class to set for the sender.
     * @return self Returns an instance of the MessageDTO.
     */
    public function setSenderClass(?string $senderClass): self
    {
        $this->senderClass = $senderClass;
        return $this;
    }

    /**
     * Get the ID of the sender.
     *
     * @return int|null The ID of the sender.
     */
    public function getSenderId(): ?int
    {
        return $this->senderId;
    }

    /**
     * Set the ID of the sender.
     *
     * @param int|null $senderId The ID to set for the sender.
     * @return self Returns an instance of the MessageDTO.
     */
    public function setSenderId(?int $senderId): self
    {
        $this->senderId = $senderId;
        return $this;
    }
}
