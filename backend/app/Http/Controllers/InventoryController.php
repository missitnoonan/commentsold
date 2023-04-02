<?php

namespace App\Http\Controllers;

use App\Http\Requests\Inventory\InventoryListRequest;
use App\Interfaces\InventoryRepositoryInterface;
use App\Library\JsonResponseData;
use App\Library\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    private InventoryRepositoryInterface $inventory_repository;

    public function __construct(InventoryRepositoryInterface $inventory_repository)
    {
        $this->inventory_repository = $inventory_repository;
    }

    public function list(InventoryListRequest $request): JsonResponse
    {
        $page = $request->input('page') ?? 1;
        $limit = $request->input('limit') ?? 20;
        $sort = $request->input('sort');
        $sort_direction = $request->input('sort_direction') ?? 'desc';
        $search = $request->input('search') ?? '';

        $list = $this->inventory_repository->list($page, $limit, $sort, $sort_direction, $search);

        return response()->json(JsonResponseData::formatData(
            $request,
            '',
            Message::MESSAGE_OK,
            $list,
        ));
    }

    public function view(Request $request, $id): JsonResponse
    {
        $inventory_item = $this->inventory_repository->find($id);
        if ($inventory_item['product']['admin_id'] === auth()->user()->id) {
            return response()->json(JsonResponseData::formatData(
                $request,
                '',
                Message::MESSAGE_OK,
                $inventory_item,
            ));
        }

        return response()->json(JsonResponseData::formatData(
            $request,
            'Unauthorized',
            Message::MESSAGE_WARNING,
            [],
        ));
    }
}
