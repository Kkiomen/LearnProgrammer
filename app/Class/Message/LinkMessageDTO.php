<?php

namespace App\Class\Message;

use App\Class\Message\Interface\MessageInterface;
use App\Class\Message\Utils\UrlMessage;
use Illuminate\Support\Collection;

class LinkMessageDTO extends MessageDTO implements MessageInterface
{
    private Collection $urls;

    public function __construct() {
        $this->urls = new Collection();
    }

    /**
     * Adds a new URL to the collection
     *
     * @param UrlMessage $urlMessage
     * @return self
     */
    public function addUrl(UrlMessage $urlMessage): self
    {
        $this->urls->add($urlMessage);
        return $this;
    }

    /**
     * Returns the collection of URLs
     *
     * @return Collection The collection of URLs
     */
    public function getUrls(): Collection
    {
        return $this->urls;
    }

    /**
     * Returns the collection of URLs as an array
     *
     * @return array An array with URLs and their related names
     */
    public function getArray(): array
    {
        $result = [];

        /**
         * @var UrlMessage $url
         */
        foreach ($this->urls as $url){
            $result[] = [
              'url' => $url->getUrl(),
              'name' => $url->getName()
            ];
        }
        return $result;
    }
}
