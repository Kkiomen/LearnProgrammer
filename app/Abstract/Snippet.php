<?php

namespace App\Abstract;

abstract class Snippet
{
    private string $name;
    protected bool $fullResponse = true;
    protected bool $manyResponse = false;

    protected ?array $data = null;

    public function getName(): string
    {
        return $this->name;
    }

    public abstract function canDisplaySnippet(): bool;

    public abstract function resultSnippet($message): string;

    public function execute($message): array
    {
        return [
            'message' => $this->resultSnippet($message),
            'fullResponse' => $this->fullResponse,
            'data' => $this->data,
            'manyResponse' => $this->manyResponse
        ];
    }
}
