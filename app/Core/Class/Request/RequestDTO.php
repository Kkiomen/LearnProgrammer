<?php

namespace App\Core\Class\Request;

use App\Core\Class\Event\Interface\EventInterface;

class RequestDTO
{
    /**
     * @var ?string $message - The message user's sent
     */
    private ?string $message = null;

    /**
     * @var ?int $assistantId - The id of the assistant
     */
    private ?int $assistantId = null;

    /**
     * @var ?int $consultantId - The id of the consultant
     */
    private ?int $consultantId = null;

    /**
     * @var ?string $sessionHash - The hash of the session
     */
    private ?string $sessionHash = null;

    /**
     * @var ?EventInterface $event - The event related to the request
     */
    private ?EventInterface $event = null;

    /**
     * @var ?array $others - An array of other information
     */
    private ?array $others = null;

    /**
     * Get the value of message
     *
     * @return ?string
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * Set the value of message
     *
     * @param ?string $message
     * @return self
     */
    public function setMessage(?string $message): self
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Get the value of assistant
     *
     * @return ?int
     */
    public function getAssistantId(): ?int
    {
        return $this->assistantId;
    }

    /**
     * Set the value of assistant
     *
     * @param ?int $assistantId
     * @return self
     */
    public function setAssistantId(?int $assistantId): self
    {
        $this->assistantId = $assistantId;
        return $this;
    }

    /**
     * Get the value of consultant
     *
     * @return ?int
     */
    public function getConsultantId(): ?int
    {
        return $this->consultantId;
    }

    /**
     * Set the value of consultant
     *
     * @param ?int $consultantId
     * @return self
     */
    public function setConsultantId(?int $consultantId): self
    {
        $this->consultantId = $consultantId;
        return $this;
    }

    /**
     * Get the value of sessionHash
     *
     * @return ?string
     */
    public function getSessionHash(): ?string
    {
        return $this->sessionHash;
    }

    /**
     * Set the value of sessionHash
     *
     * @param ?string $sessionHash
     * @return self
     */
    public function setSessionHash(?string $sessionHash): self
    {
        $this->sessionHash = $sessionHash;
        return $this;
    }

    /**
     * Get the value of event
     *
     * @return ?EventInterface
     */
    public function getEvent(): ?EventInterface
    {
        return $this->event;
    }

    /**
     * Set the value of event
     *
     * @param ?EventInterface $event
     * @return self
     */
    public function setEvent(?EventInterface $event): self
    {
        $this->event = $event;
        return $this;
    }

    /**
     * Get the value of others
     *
     * @return ?array
     */
    public function getOthers(): ?array
    {
        return $this->others;
    }

    /**
     * Set the value of others
     *
     * @param ?array $others
     * @return self
     */
    public function setOthers(?array $others): self
    {
        $this->others = $others;
        return $this;
    }
}
