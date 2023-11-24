<?php

namespace App\Class\Message\Utils;

class UrlMessage
{
    private string $url;
    private string $name;

    public function __construct(string $url, string $name)
    {
        $this->url = $url;
        $this->name = $name;
    }

    public function toArray(): array
    {
        return [
          'url' => $this->getUrl(),
          'name' => $this->getName()
        ];
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
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
