<?php

namespace App\CoreAssistant\Adapter\Repository\EloquentRepository;

use App\CoreAssistant\Adapter\Repository\EloquentRepository\Exceptions\NullModelForEloquentRepository;
use App\CoreAssistant\Adapter\Repository\Interface\RepositoryInterface;
use App\CoreAssistant\Core\Collection\Collection;
use App\CoreAssistant\Core\Domain\Abstract\Entity;
use Illuminate\Database\Eloquent\Model;

abstract class EloquentRepository implements RepositoryInterface
{

    protected ?string $model = null;

    public function findAll(): ?Collection
    {
        if($this->model === null){
            throw new NullModelForEloquentRepository();
        }

        $model = new $this->model();
        $modelsFromEloquent = $model::all();

        return $this->convertToCollection($modelsFromEloquent);
    }

    public function findById(int $id): ?Entity
    {
        if($this->model === null){
            throw new NullModelForEloquentRepository();
        }

        $model = new $this->model();
        $model = $model::find($id);

        return $model ? $this->mapModelToEntity($model) : null;
    }

    public function findBy(array $criteria): ?Collection
    {
        if($this->model === null){
            throw new NullModelForEloquentRepository();
        }

        $this->validateCriteria($criteria);

        $key = key($criteria);
        $value = $criteria[$key];

        $model = new $this->model();
        $modelsFromEloquent = $model::where($key, $value)->get();

        return $this->convertToCollection($modelsFromEloquent);
    }

    public function findOneBy(array $criteria): ?Entity
    {
        if($this->model === null){
            throw new NullModelForEloquentRepository();
        }

        $this->validateCriteria($criteria);

        $key = key($criteria);
        $value = $criteria[$key];

        $model = new $this->model();
        $model = $model::where($key, $value)->first();

        return $model ? $this->mapModelToEntity($model) : null;
    }

    public function exists(array $criteria): bool
    {
        if($this->model === null){
            throw new NullModelForEloquentRepository();
        }

        $this->validateCriteria($criteria);

        $key = key($criteria);
        $value = $criteria[$key];

        $model = new $this->model();
        return $model::where($key, $value)->exists();
    }

    public function save(Entity $entity): Entity|bool
    {
        $model = $this->mapEntityToModel($entity);
        if($model->save()){
            return $this->mapModelToEntity($model);
        }
        return false;
    }

    protected function getOrCreateModel(int $id): Model
    {
        if($this->model === null){
            throw new NullModelForEloquentRepository();
        }

        $model = new $this->model();
        $model = $model::find($id);

        if($model === null){
            $model = new $this->model();
        }

        return $model;
    }


    protected function convertToCollection(\Illuminate\Database\Eloquent\Collection $collectionsModel): Collection
    {
        $collection = new Collection();

        foreach ($collectionsModel as $model){
            $collection->add($this->mapModelToEntity($model));
        }

        return $collection;
    }

    private function validateCriteria(array $criteria): void
    {
        if(empty($criteria)){
            throw new \InvalidArgumentException('Criteria cannot be empty');
        }

        if(count($criteria) !== 1){
            throw new \InvalidArgumentException('Criteria must have only one element');
        }
    }

    abstract function mapModelToEntity(Model $model): Entity;
    abstract function mapEntityToModel(Entity $entity): Model;
}
