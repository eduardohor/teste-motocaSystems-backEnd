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

    public function index(): JsonResponse
    {
        $categories = $this->category->with('products')->orderByDesc('created_at')->paginate(10);

        return response()->json([
            'status' => true,
            'categorias' => $categories
        ], 200);
    }

    public function show(Request $request)
    {
        $category = $this->category->with('products')->find($request->id);

        if (!$category) {
            return response()->json([
                'status' => false,
                'mensagem' => 'Categoria não encontrada.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'categoria' => $category
        ], 200);
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
                'message' => 'Erro ao cadastrar categoria.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(CategoryRequest $request): JsonResponse
    {
        $category = $this->category->find($request->id);

        if (!$category) {
            return response()->json([
                'status' => false,
                'mensagem' => 'Categoria não encontrada.'
            ], 404);
        }

        DB::beginTransaction();

        try {
            $category->update($request->all());

            DB::commit();

            return response()->json([
                'status' => true,
                'mensagem' => 'Categoria atualizada com sucesso!',
                'categoria' => $category
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'mensagem' => 'Erro ao atualizar categoria',
                'error' => $e->getMessage()
            ], 500);
        }

    }

    public function destroy(Request $request): JsonResponse
    {
        $category = $this->category->find($request->id);

        if (!$category) {
            return response()->json([
                'status' => false,
                'mensagem' => 'Categoria não encontrada.'
            ], 404);
        }

        DB::beginTransaction();

        try {
            $category->delete();
            DB::commit();

            return response()->json([
                'status' => true,
                'mensagem' => 'Categoria removida com sucesso!',
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'mensagem' => 'Erro ao remover categoria.',
                'error' => $e->getMessage()
            ], 500);
        }

    }

}
