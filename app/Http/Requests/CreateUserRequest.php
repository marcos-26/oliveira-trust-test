<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cpf' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'endereco' => 'required|array',
            'endereco.bairro' => 'required|string|max:255',
            'endereco.cep' => 'required|string|max:10',
            'endereco.cidade' => 'required|string|max:255',
            'endereco.complemento' => 'string',
            'endereco.estado' => 'required|string|max:255',
            'endereco.logradouro' => 'required|string|max:255',
            'endereco.numero' => 'required|string|max:10',
            'endereco.pais' => 'required|string',
            'nascimento' => 'required|date',
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string|max:255',
        ];
    }
}
