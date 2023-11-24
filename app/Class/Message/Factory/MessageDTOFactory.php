<?php

namespace App\Class\Message\Factory;

use App\Class\Message\ImageMessageDTO;
use App\Class\Message\Interface\MessageInterface;
use App\Class\Message\LinkMessageDTO;
use App\Class\Message\MessageDTO;
use App\Class\Message\Utils\PhotoMessage;
use App\Class\Message\Utils\UrlMessage;
use App\Class\PromptHistory\Prompt;
use Illuminate\Support\Facades\Auth;

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
    public function createMessageDTO(
        int $id = null,
        int $conversationId = null,
        string $content = null,
        int $senderId = null,
        string $senderClass = null,
        array $urls = [],
        array $images = [],
        string $prompt = null,
        string $system = null,
        int $userId = null,
        string $result = null,
        string $links = null
    ): MessageInterface {
        $message = new MessageDTO();
        $message->setId($id ?? null);
        $message->setContent($content ?? null);
        $message->setSenderClass($senderClass ?? null);
        $message->setSenderId($senderId ?? null);
        $message->setUserId($userId ?? Auth::user()->id ?? null);
        $message->setConversionId($conversationId ?? null);
        $message->setResult($result ?? null);
        $message->setLinks($links ?? null);

        if($prompt !== null || $system !== null){
            $promptHistory = new Prompt($prompt, $system);
            $message->setPromptHistory($promptHistory);
        }

        $message->setSenderId($senderId ?? null);

        if (!empty($images)) {
            $message = new ImageMessageDTO();
            foreach ($images as $image) {
                $photoMessage = new PhotoMessage($image['path'], $image['name']);
                $message->addImage($photoMessage);
            }
        }

        if (!empty($urls)) {
            $message = new LinkMessageDTO();
            foreach ($urls as $url) {
                $urlMessage = new UrlMessage($url['url'], $url['name']);
                $message->addUrl($urlMessage);
            }
        }

        return $message;
    }
}
