<?php

namespace App\Mapper;

use App\Dto\WorklogDto;
use App\Models\Worklog;

class WorklogMapper
{
    public function toDto(Worklog $worklog): WorklogDto
    {
        $dto = new WorklogDto();
        $dto->setDescription($worklog->description);
        $dto->setDurationMinutes($worklog->duration_minutes);
        $dto->setIssueName($worklog->issue_name);
        $dto->setUserId($worklog->user_id);
        $dto->setCreatedAt($worklog->created_at);

        return $dto;
    }

    public function toModel(WorklogDto $dto): Worklog
    {
        $worklog = new Worklog([
            'description' => $dto->getDescription(),
            'duration_minutes' => $dto->getDurationMinutes(),
            'issue_name' => $dto->getIssueName(),
            'user_id' => $dto->getUserId(),
            'created_at' => $dto->getCreatedAt()
        ]);

        return $worklog;
    }
}
