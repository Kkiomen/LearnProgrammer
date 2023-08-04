<?php

namespace App\Modules;

use App\Enum\DataSource;

class Modules
{
    protected ?DataSource $dataSource = null;

    /**
     * Get the information where the data came from
     * @return DataSource
     * @throws \Exception
     */
    public function getDataSource(): DataSource
    {
        if(is_null($this->dataSource)){
            throw new \Exception('For proper operation of the system, it is required to specify where the data (used in the adapter) comes from');
        }

        return $this->dataSource;
    }
}
