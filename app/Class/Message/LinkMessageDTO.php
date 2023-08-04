<?php

namespace App\Class\Message;

use App\Class\Message\Interface\MessageInterface;
use App\Class\Message\Utils\UrlMessage;
use Illuminate\Support\Collection;

class LinkMessageDTO implements MessageInterface
{
    private Collection $urls;
    private MessageInterface $message;

    public function __construct(MessageInterface $message) {
        $this->urls = new Collection();
        $this->message = $message;
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

    /**
     * Get the content of the message.
     *
     * @return string|null The content of the message.
     */
    public function getContent(): ?string
    {
        return $this->message->getContent();
    }

    /**
     * Set the content of the message.
     *
     * @param string|null $content The content to set for the message.
     * @return MessageInterface Returns an instance of the MessageInterface.
     */
    public function setContent(string|null $content): MessageInterface
    {
        return $this->message->setContent($content);
    }

    /**
     * Get the class of the sender.
     *
     * @return string|null The class of the sender.
     */
    public function getSenderClass(): ?string
    {
        return $this->message->getSenderClass();
    }

    /**
     * Set the class of the sender.
     *
     * @param string|null $senderClass The class to set for the sender.
     * @return MessageInterface Returns an instance of the MessageInterface.
     */
    public function setSenderClass(string|null $senderClass): MessageInterface
    {
        return $this->message->setSenderClass($senderClass);
    }

    /**
     * Get the ID of the sender.
     *
     * @return int|null The ID of the sender.
     */
    public function getSenderId(): ?int
    {
        return $this->message->getSenderId();
    }

    /**
     * Set the ID of the sender.
     *
     * @param int|null $senderId The ID to set for the sender.
     * @return MessageInterface Returns an instance of the MessageInterface.
     */
    public function setSenderId(?int $senderId): MessageInterface
    {
        return $this->message->setSenderClass($senderId);
    }

    /**
     * Get the ID of the message.
     *
     * @return int|null The ID of the message.
     */
    public function getId(): ?int
    {
        return $this->message->getId();
    }

    /**
     * Set the ID of the message.
     *
     * @param int|null $id The ID to set for the message.
     * @return MessageInterface Returns an instance of the MessageInterface.
     */
    public function setId(?int $id): MessageInterface
    {
        return $this->message->setId($id);
    }
}
