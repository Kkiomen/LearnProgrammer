<?php

namespace App\Class\Message\Factory;

use App\Class\Message\ImageMessageDTO;
use App\Class\Message\Interface\MessageInterface;
use App\Class\Message\LinkMessageDTO;
use App\Class\Message\MessageDTO;
use App\Class\Message\Utils\PhotoMessage;
use App\Class\Message\Utils\UrlMessage;

final class MessageDTOFactory
{
    /**
     * Create a new MessageInterface instance with optional parameters for different message types.
     *
     * @param int|null $id The ID of the message (optional).
     * @param string|null $content The content of the message (optional).
     * @param int|null $senderId The ID of the sender (optional).
     * @param string|null $senderClass The class of the sender (optional).
     * @param array $urls An array of associative arrays containing 'url' and 'name' keys for link messages (optional).
     * @param array $images An array of associative arrays containing 'path' and 'name' keys for image messages (optional).
     *
     * @return MessageInterface A new instance of MessageInterface or its subclass (ImageMessage or LinkMessage).
     */
    public static function createMessage(
        int $id = null,
        string $content = null,
        int $senderId = null,
        string $senderClass = null,
        array $urls = [],
        array $images = []
    ): MessageInterface {
        $message = new MessageDTO();
        $message->setId($id ?? null);
        $message->setContent($content ?? null);
        $message->setSenderClass($senderClass ?? null);
        $message->setSenderId($senderId ?? null);

        if (!empty($images)) {
            $message = new ImageMessageDTO($message);
            foreach ($images as $image) {
                $photoMessage = new PhotoMessage($image['path'], $image['name']);
                $message->addImage($photoMessage);
            }
        }

        if (!empty($urls)) {
            $message = new LinkMessageDTO($message);
            foreach ($urls as $url) {
                $urlMessage = new UrlMessage($url['url'], $url['name']);
                $message->addUrl($urlMessage);
            }
        }

        return $message;
    }
}
