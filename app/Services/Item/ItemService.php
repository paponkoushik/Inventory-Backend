<?php

namespace App\Services\Item;

use App\Models\Item;
use App\Services\BaseService;
use App\Services\Traits\FileHandler;

class ItemService extends BaseService
{
    use FileHandler;
    public function __construct(Item $item)
    {
        $this->model = $item;
    }

    public function store(): ItemService
    {
        if ($this->getAttr('image')) {
            $this->uploadFile();
        }

        $this->model = parent::save($this->getAttrs());

        return $this;
    }

    public function uploadFile()
    {
        $this->setAttr(
            'image',
            $this->storeFile($this->getAttr('image'))
        );
    }

    public function update(): ItemService
    {
        if ($this->getAttr('image')) $this->uploadFile();

        $this->model->fill($this->getAttrs())->save();

        return $this;
    }

    public function getData(): Item
    {
        return $this->model->load('inventory');
    }
}
