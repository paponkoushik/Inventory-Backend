<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemRequest;
use App\Models\Item;
use App\Services\Item\ItemService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    protected $service;

    public function __construct(ItemService $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        $item = Item::query()
            ->with('inventory')
            ->where('user_id', auth()->user()->id)
            ->paginate(10);

        return response()->json($item, 200);
    }

    public function store(ItemRequest $request): JsonResponse
    {
        $item = DB::transaction(function () use ($request) {
            return $this->service
                ->setAttrs($request->only('name', 'description', 'quantity', 'inventory_id', 'image'))
                ->setAttr('user_id', auth()->user()->id)
                ->store()
                ->getData();
        });

        return response()->json(['data' => $item, 'message' => 'Item has been created successfully'], 200);
    }

    public function show(item $item): JsonResponse
    {
        return response()->json($item->load('inventory'), 200);
    }

    public function update(ItemRequest $request, Item $item): JsonResponse
    {
        $item = DB::transaction(function () use ($request, $item) {
            return $this->service
                ->setAttrs($request->only('name', 'description', 'quantity', 'inventory_id', 'image'))
                ->setModel($item)
                ->update()
                ->getData();
        });

        return response()->json(['data' => $item, 'message' => 'Item has been updated successfully'], 200);
    }

    public function delete(Item $item): JsonResponse
    {
        $this->service ->setModel($item)->delete();

        return response()->json(['message' => 'Item has been deleted successfully'], 200);
    }

}
