<?php

namespace App\Services\Inventory;

use App\Models\Inventory;
use App\Services\BaseService;

class InventoryService extends BaseService
{
    public function __construct(Inventory $inventory)
    {
        $this->model = $inventory;
    }

    public function store(): InventoryService
    {
        $this->model = parent::save($this->getAttrs());

        return $this;
    }

    public function update(): InventoryService
    {
        $this->model->fill($this->getAttrs())->save();

        return $this;
    }

    public function getData(): Inventory
    {
        return $this->model;
    }


}
