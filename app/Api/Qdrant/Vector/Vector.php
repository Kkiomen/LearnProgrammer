<?php

namespace App\Api\Qdrant\Vector;

class Vector
{
    private ?array $payload;
    private array $vector;

    /**
     * @param array $embedding
     * @param array|null $payload
     */
    public function __construct(array $embedding, array $payload = null)
    {
        $this->payload = $payload;
        $this->vector = $embedding;
    }

    public function getPayload(): ?array
    {
        return $this->payload ?? [];
    }

    public function setPayload(array $payload): void
    {
        $this->payload = $payload;
    }

    public function getVector(): array
    {
        return $this->vector;
    }

    public function setVector(array $vector): void
    {
        $this->vector = $vector;
    }
}
