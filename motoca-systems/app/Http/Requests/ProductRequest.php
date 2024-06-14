<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function failedValidation(Validator $validator): JsonResponse
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'erros' => $validator->errors()
        ], 422));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'preco' => 'required|numeric|min:0'
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'category_id.required' => 'A categoria é obrigatória.',
            'category_id.exists' => 'A categoria selecionada é inválida.',
            'nome.required' => 'O nome do produto é obrigatório.',
            'nome.string' => 'O nome do produto deve ser um texto.',
            'nome.max' => 'O nome do produto não pode ter mais de 255 caracteres.',
            'descricao.required' => 'A descrição do produto é obrigatória.',
            'descricao.string' => 'A descrição do produto deve ser um texto.',
            'preco.required' => 'O preço do produto é obrigatório.',
            'preco.numeric' => 'O preço do produto deve ser um número.',
            'preco.min' => 'O preço do produto deve ser pelo menos 0.',
        ];
    }
}
