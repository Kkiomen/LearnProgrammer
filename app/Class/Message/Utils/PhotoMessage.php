<?php

namespace App\Class\Message\Utils;

class PhotoMessage
{
    private string $path;
    private string $name;

    public function __construct(string $url, string $name)
    {
        $this->path = $url;
        $this->name = $name;
    }

    public function toArray(): array
    {
        return [
            'url' => $this->getPath(),
            'name' => $this->getName()
        ];
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
