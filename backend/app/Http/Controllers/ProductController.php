<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductListRequest;
use App\Interfaces\ProductRepositoryInterface;
use App\Library\JsonResponseData;
use App\Library\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductRepositoryInterface $product_repository;

    public function __construct(ProductRepositoryInterface $product_repository)
    {
        $this->product_repository = $product_repository;
    }

    public function list(ProductListRequest $request): JsonResponse
    {
        $page = $request->input('page') ?? 1;
        $limit = $request->input('limit') ?? 20;
        $sort = $request->input('sort');
        $sort_direction = $request->input('sort_direction') ?? 'desc';

        $list = $this->product_repository->list($page, $limit, $sort, $sort_direction);

        return response()->json(JsonResponseData::formatData(
            $request,
            '',
            Message::MESSAGE_OK,
            $list,
        ));
    }

    public function view(Request $request, $id): JsonResponse
    {
        $product = $this->product_repository->find($id);

        if ($product['admin_id'] === auth()->user()->id) {
            return response()->json(JsonResponseData::formatData(
                $request,
                '',
                Message::MESSAGE_OK,
                $product,
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
