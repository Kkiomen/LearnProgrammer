<?php

namespace App\Dao;

use App\Dto\WorklogDto;
use App\Mapper\WorklogMapper;
use App\Models\Worklog;

class WorklogDao
{
    private WorklogMapper $worklogMapper;

    /**
     * @param WorklogMapper $worklogMapper
     */
    public function __construct(WorklogMapper $worklogMapper)
    {
        $this->worklogMapper = $worklogMapper;
    }


    public function create(WorklogDto $worklogDto): Worklog
    {
        $worklog = $this->worklogMapper->toModel($worklogDto);
        $worklog->save();
        return $worklog;
    }
}
