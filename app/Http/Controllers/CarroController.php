<?php

namespace App\Http\Controllers;

use App\Models\Carro;
use App\Models\User;
use Illuminate\Http\Request;

class CarroController extends Controller
{
    public function index()
    {
        $carros = Carro::all();
        return response()->json(['carros' => $carros], 200);
    }

    public function show($id)
    {
        $carro = Carro::find($id);

        if (!$carro) {
            return response()->json(['message' => 'Carro não encontrado'], 404);
        }

        return response()->json(['carro' => $carro], 200);
    }

    public function store(Request $request)
    {
        $userId = $request->input('user_id');

        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $carro = new Carro(); // Criar uma nova instância de Carro

        $carroData = [
            'marca' => $request->input('marca'),
            'modelo' => $request->input('modelo'),
            'cor' => $request->input('cor'),
        ];

        // Preencher os dados do carro
        $carro->fill($carroData);

        // Salva o carro diretamente no relacionamento embedsOne do usuário
        $user->carro()->save($carro);

        return response()->json($user->carro);
    }

    public function update(Request $request, $userId)
    {
        $carroId = $request['idcarro'];

        $user = User::find($userId);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Recupera o carro associado ao usuário
        $carro = $user->carro;

        if (!$carro) {
            return response()->json(['message' => 'Carro not found'], 404);
        }

        // Atualiza os dados do carro
        $carro->marca = $request->input('marca');
        $carro->modelo = $request->input('modelo');
        $carro->cor = $request->input('cor');
        $carro->save();

        return response()->json($carro);
    }

    public function destroy(Request $request, $userId)
    {
        $carroId = $request['idcarro'];

        $user = User::find($userId);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Recupera o carro associado ao usuário
        $carro = $user->carro;

        if (!$carro) {
            return response()->json(['message' => 'Carro not found'], 404);
        }

        // Exclui o carro
        $carro->delete();

        return response()->json(['message' => 'Carro deleted successfully']);
    }

}
