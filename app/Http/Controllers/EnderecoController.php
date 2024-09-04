<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{
    public function index()
    {
        return Endereco::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'logradouro' => 'required|string|max:255',
            'numero' => 'required|string|max:10',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'cep' => 'required|string|max:10',
        ]);

        $userId = $request['_id'];
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $endereco = new Endereco();
        $endereco->logradouro = $request->input('logradouro');
        $endereco->numero = $request->input('numero');
        $endereco->bairro = $request->input('bairro');
        $endereco->cidade = $request->input('cidade');
        $endereco->estado = $request->input('estado');
        $endereco->cep = $request->input('cep');
        $endereco->user_id = $userId;
        $endereco->save();

        return response()->json($endereco);
    }

    public function show($id)
    {
        return Endereco::findOrFail($id);
    }

    public function update(Request $request, $userId)
    {
        $idendereco = $request['idendereco'];

        $user = User::find($userId);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $endereco = Endereco::find($idendereco);
        if (!$endereco) {
            return response()->json(['message' => 'Endereco not found'], 404);
        }

        $endereco->rua = $request->input('rua');
        $endereco->cidade = $request->input('cidade');
        $endereco->estado = $request->input('estado');
        $endereco->save();

        return response()->json($endereco);
    }

    public function destroy(Request $request, $userId)
    {
        $idendereco = $request['idendereco'];

        $user = User::find($userId);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $endereco = Endereco::find($idendereco);
        if (!$endereco) {
            return response()->json(['message' => 'Endereco not found'], 404);
        }

        $endereco->delete();
        return response()->json(['message' => 'Endereco deleted successfully']);
    }
}
