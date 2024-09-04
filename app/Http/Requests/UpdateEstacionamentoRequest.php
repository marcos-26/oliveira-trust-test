<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEstacionamentoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'sometimes|string',
            'razaosocial' => 'sometimes|string',
            'cnpj' => 'sometimes|integer',
            'endereco' => 'sometimes|array',
            'endereco.bairro' => 'sometimes|string|max:255',
            'endereco.cep' => 'sometimes|string|max:10',
            'endereco.cidade' => 'sometimes|string|max:255',
            'endereco.complemento' => 'sometimes|string',
            'endereco.estado' => 'sometimes|string|max:255',
            'endereco.logradouro' => 'sometimes|string|max:255',
            'endereco.numero' => 'sometimes|string|max:10',
            'endereco.pais' => 'sometimes|string',
            'vagas' => 'sometimes|integer',
            'whatssap' => 'sometimes|integer',
            'mensagem' => 'sometimes|string',
            'location' => 'sometimes|array|size:2',
        ];
    }
}
