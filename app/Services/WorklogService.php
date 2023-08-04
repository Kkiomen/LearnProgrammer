<?php

namespace App\Services;

use App\Dao\WorklogDao;
use App\Dto\WorklogDto;
use App\Models\Worklog;
use Illuminate\Support\Facades\Auth;

class WorklogService
{
    private WorklogDao $worklogDao;

    /**
     * @param WorklogDao $worklogDao
     */
    public function __construct(WorklogDao $worklogDao)
    {
        $this->worklogDao = $worklogDao;
    }


    public function createWorklog($description, $durationMinutes, $issueName, $createdAt = null): Worklog
    {
        $worklogDto = new WorklogDto();
        $worklogDto->setDescription($description);
        $worklogDto->setDurationMinutes($durationMinutes);
        $worklogDto->setIssueName($issueName);
        $worklogDto->setUserId(Auth::user()->id);
        $worklogDto->setCreatedAt($createdAt);
        return $this->worklogDao->create($worklogDto);
    }

    public function getWorklogData($date = null){

    }
}
