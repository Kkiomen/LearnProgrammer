<?php

namespace App\Dto;

use Carbon\Carbon;

class WorklogDto
{
    private int $user_id;
    private ?string $description;
    private ?string $duration_minutes;
    private ?string $issue_name;
    private ?string $created_at;

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string|null
     */
    public function getDurationMinutes(): ?string
    {
        return $this->duration_minutes;
    }

    /**
     * @param string|null $duration_minutes
     */
    public function setDurationMinutes(?string $duration_minutes): void
    {
        $this->duration_minutes = $duration_minutes;
    }

    /**
     * @return string|null
     */
    public function getIssueName(): ?string
    {
        return $this->issue_name;
    }

    /**
     * @param string|null $issue_name
     */
    public function setIssueName(?string $issue_name): void
    {
        $this->issue_name = $issue_name;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        if(empty($this->created_at)){
            return Carbon::now()->toDateTimeString();
        }
        return $this->created_at;
    }

    /**
     * @param string|null $created_at
     */
    public function setCreatedAt(?string $created_at): void
    {
        $this->created_at = $created_at;
    }


}
