<?php

namespace App\Core\Abstract;

use App\Core\Interfaces\DTOInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class Mapper
{
    public function mapCollectionToDTO(array|\Illuminate\Database\Eloquent\Collection $models): Collection
    {
        $collection = new Collection();
        foreach ($models as $conversation) {
            $collection->add($this->mapToDTO($conversation));
        }
        return $collection;
    }

    abstract public function mapToDTO(Model $model): DTOInterface;
    abstract public function mapToModel(DTOInterface $dtoClass): Model;

}
