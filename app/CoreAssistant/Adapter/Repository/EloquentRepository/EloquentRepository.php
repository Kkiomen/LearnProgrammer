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

        return $this->mapModelToEntity($model);
    }

    public function findBy(array $criteria): ?Collection
    {
        if($this->model === null){
            throw new NullModelForEloquentRepository();
        }

        $model = new $this->model();
        $modelsFromEloquent = $model::where($criteria)->get();

        return $this->convertToCollection($modelsFromEloquent);
    }

    public function findOneBy(array $criteria): ?Entity
    {
        if($this->model === null){
            throw new NullModelForEloquentRepository();
        }

        $model = new $this->model();
        $model = $model::where($criteria)->first();

        return $this->mapModelToEntity($model);
    }

    public function exists(array $criteria): bool
    {
        if($this->model === null){
            throw new NullModelForEloquentRepository();
        }

        $model = new $this->model();
        return $model::where($criteria)->exists();
    }

    public function save(Entity $entity): bool
    {
        $model = $this->mapEntityToModel($entity);

        return $model->save();
    }

    private function convertToCollection(\Illuminate\Database\Eloquent\Collection $collectionsModel): Collection
    {
        $collection = new Collection();

        foreach ($collectionsModel as $model){
            $collection->add($this->mapModelToEntity($model));
        }

        return $collection;
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

    abstract function mapModelToEntity(Model $model): Entity;
    abstract function mapEntityToModel(Entity $entity): Model;
}
