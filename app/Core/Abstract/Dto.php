<?php

namespace App\Core\Abstract;

use App\Core\Interfaces\DTOInterface;

abstract class Dto implements DTOInterface
{
    /**
     * @var int|null The ID of the DTO class.
     */
    private ?int $id;

    /**
     * Get the ID of the DTO class.
     *
     * @return int|null The ID of the DTO class.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the ID of the DTO class.
     *
     * @param int|null $id The ID to set for the DTO class.
     * @return self Returns an instance of the DTO class.
     */
    public function setId(int|null $id): self
    {
        $this->id = $id;
        return $this;
    }
}
