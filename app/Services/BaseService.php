<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class BaseService
{
    protected $attributes = [];

    protected $model;

    public function setAttrs(array $attrs): self
    {
        $this->attributes = $attrs;

        return $this;
    }

    public function setAttr($key, $value): self
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    public function getAttrs($columns = null): array
    {
        $columns = is_array($columns) ? $columns : func_get_args();

        if (count($columns)) {
            return Arr::only($this->attributes, $columns);
        }

        return $this->attributes;
    }

    public function getAttr($key, $default = null)
    {
        return isset($this->attributes[$key]) ? $this->attributes[$key] : $default;
    }

    public function setModel(Model $model): BaseService
    {
        $this->model = $model;
        return $this;
    }

    public function getFillAble($parameters = []): array
    {
        return count($this->attributes) ? $this->attributes : $parameters;
    }

    public function save($options = [])
    {
        $attributes = count($options) ? $options : request()->all();

        $this->model
            ->fill($this->getFillAble($attributes))
            ->save();

        return $this->model;
    }

    public function __call($method, $arguments)
    {
        return $this->model->{$method}(...$arguments);
    }
}
