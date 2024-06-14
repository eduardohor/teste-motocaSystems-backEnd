<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    protected $product;

    public function __construct(Product $product)
    {

        $this->product = $product;
    }

    public function index(): JsonResponse
    {
        $products = $this->product->orderByDesc('created_at')->paginate(10);

        return response()->json([
            'status' => true,
            'produtos' => $products
        ], 200);
    }

    public function show(Request $request)
    {
        $product = $this->product->find($request->id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'mensagem' => 'Produto não encontrado.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'produto' => $product
        ], 200);
    }

    public function store(ProductRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $product = $this->product->create([
                'category_id' => $request->category_id,
                'nome' => $request->nome,
                'descricao' => $request->descricao,
                'preco' => $request->preco
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'mensagem' => 'Produto cadastrado com sucesso!',
                'produtos' => $product
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Erro ao cadastrar produto.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(ProductRequest $request): JsonResponse
    {
        $product = $this->product->find($request->id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'mensagem' => 'Produto não encontrado.'
            ], 404);
        }

        DB::beginTransaction();

        try {
            $product->update($request->all());

            DB::commit();

            return response()->json([
                'status' => true,
                'mensagem' => 'Produto atualizado com sucesso!',
                'produto' => $product
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'mensagem' => 'Erro ao atualizar produto',
                'error' => $e->getMessage()
            ], 500);
        }

    }

    public function destroy(Request $request): JsonResponse
    {
        $product = $this->product->find($request->id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'mensagem' => 'Produto não encontrado.'
            ], 404);
        }

        DB::beginTransaction();

        try {
            $product->delete();
            DB::commit();

            return response()->json([
                'status' => true,
                'mensagem' => 'Produto removido com sucesso!',
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'mensagem' => 'Erro ao remover produto.',
                'error' => $e->getMessage()
            ], 500);
        }

    }
}
