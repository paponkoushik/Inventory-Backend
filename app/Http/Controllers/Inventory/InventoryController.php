<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\InventoryRequest;
use App\Models\Inventory;
use App\Services\Inventory\InventoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    protected $service;

    public function __construct(InventoryService $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        $inventory = Inventory::query()->where('user_id', auth()->user()->id)->paginate(10);

        return response()->json($inventory, 200);
    }
    public function allInventories(): JsonResponse
    {
        $inventory = cache()->rememberForever('inventories', function () {
            return Inventory::query()->where('user_id', auth()->user()->id)->get();
        });

        return response()->json($inventory, 200);
    }

    public function store(InventoryRequest $request): JsonResponse
    {
        $inventory = DB::transaction(function () use ($request) {
            return $this->service
                ->setAttrs($request->only('name', 'description'))
                ->setAttr('user_id', auth()->user()->id)
                ->store()
                ->getData();
        });

        return response()->json(['data' => $inventory, 'message' => 'Data has been stored successfully!'], 200);
    }

    public function show(Inventory $inventory): JsonResponse
    {
        return response()->json($inventory, 200);
    }

    public function update(InventoryRequest $request, Inventory $inventory): JsonResponse
    {
        $inventory = DB::transaction(function () use ($request, $inventory) {
            return $this->service
                ->setAttrs($request->only('name', 'description'))
                ->setModel($inventory)
                ->update()
                ->getData();
        });

        return response()->json(['data' => $inventory, 'message' => 'Data has been updated successfully!'], 200);
    }

    public function delete(Inventory $inventory): JsonResponse
    {
        $this->service->setModel($inventory)->delete();

        return response()->json(['message' => 'Inventory has been deleted successfully!'], 200);
    }
}
