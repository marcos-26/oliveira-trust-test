<?php
namespace App\Domain\Services;

use App\Models\Estacionamento;

class EstacionamentoService
{
    public function confirmarEstacionamento($id)
    {
        $estacionamento = Estacionamento::findOrFail($id);
        $vagasDisponiveis = $estacionamento->vagas;

        if (!$vagasDisponiveis > 0) {

            return response()->json(['error' => 'Não há vagas disponíveis no momento.'], 400);
        }
        $estacionamento->vagas--;
        $estacionamento->save();
    }

    public function liberaEstacionamento($id)
    {
        $estacionamento = Estacionamento::findOrFail($id);
        $vagasDisponiveis = $estacionamento->vagas;

        if (!$vagasDisponiveis > 0) {

            return response()->json(['error' => 'Não há vagas disponíveis no momento.'], 400);
        }

        $estacionamento->vagas++;
        $estacionamento->save();
    }
}
