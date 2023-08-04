<?php

namespace App\Class\Message;

use App\Class\Message\Interface\MessageInterface;
use App\Class\Message\Utils\PhotoMessage;
use Illuminate\Support\Collection;

class ImageMessageDTO implements MessageInterface
{
    private Collection $images;
    private MessageInterface $message;

    public function __construct(MessageInterface $message) {
        $this->images = new Collection();
        $this->message = $message;
    }

    /**
     * Adds a new photo to the collection
     *
     * @param PhotoMessage $photoMessage
     * @return self
     */
    public function addImage(PhotoMessage $photoMessage): self
    {
        $this->images->add($photoMessage);
        return $this;
    }

    /**
     * Returns the collection of photos
     *
     * @return Collection The collection of photos
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    /**
     * Returns the collection of photos as an array
     *
     * @return array An array with Photos and their related names
     */
    public function getArray(): array
    {
        $result = [];

        /**
         * @var PhotoMessage $url
         */
        foreach ($this->images as $url){
            $result[] = [
                'path' => $url->getPath(),
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
