<?php

namespace App\Class\Message;

use App\Class\Message\Interface\MessageInterface;
use App\Class\Message\Utils\PhotoMessage;
use Illuminate\Support\Collection;

class ImageMessageDTO extends MessageDTO implements MessageInterface
{
    private Collection $images;

    public function __construct() {
        $this->images = new Collection();
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
}
