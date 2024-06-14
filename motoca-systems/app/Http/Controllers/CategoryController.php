<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Exception;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function store(CategoryRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $category = $this->category->create([
                'nome' => $request->nome
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'mensagem' => 'Categoria cadastrada com sucesso!',
                'categoria' => $category
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Categoria não cadastrada'
            ], 400);
        }
    }
}
