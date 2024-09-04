<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEstacionamentoRequest;
use App\Http\Requests\UpdateEstacionamentoRequest;
use App\Models\Estacionamento;
use Illuminate\Http\Request;

class EstacionamentoController extends Controller
{
    // Método para exibir todos os estacionamentos
    public function index(Request $request)
    {
        $request->validate([
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        $estacionamentos = Estacionamento::query();

        if ($latitude && $longitude) {
            $estacionamentos->where('location', 'near', [
                '$geometry' => [
                    'type' => 'Point',
                    'coordinates' => [
                        floatval($longitude),
                        floatval($latitude),
                    ],
                ],
                '$maxDistance' => 3000, // Distância máxima em metros
            ]);
        }

        return response()->json($estacionamentos->get());
    }

    // Método para armazenar um novo estacionamento
    public function store(Request $request)
    {
        $estacionamento = Estacionamento::create($request->all());
        return response()->json($estacionamento, 201);
    }

    // Método para exibir um estacionamento específico
    public function show($id)
    {
        $estacionamento = Estacionamento::findOrFail($id);
        return response()->json($estacionamento, 200);
    }

    // Método para atualizar um estacionamento
    public function update(UpdateEstacionamentoRequest $request, $id)
    {
        $estacionamento = Estacionamento::findOrFail($id);
        $estacionamento->update($request->except('endereco'));
        $estacionamento->endereco->update($request->only('endereco'));

        return response()->json($estacionamento, 200);
    }

    // Método para excluir um estacionamento
    public function destroy($id)
    {
        $estacionamento = Estacionamento::findOrFail($id);
        $estacionamento->delete();

        return response()->json(null, 204);
    }

    // Método para mostrar apenas o número de vagas de um estacionamento
    public function showVagas($id)
    {
        $estacionamento = Estacionamento::findOrFail($id);
        $vagas = $estacionamento->vagas;

        return response()->json(['vagas' => $vagas], 200);
    }

}
