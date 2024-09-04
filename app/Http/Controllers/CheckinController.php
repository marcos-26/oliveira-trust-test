<?php

namespace App\Http\Controllers;

use App\Domain\Services\EstacionamentoService;
use App\Models\Checkin;
use App\Models\Estacionamento;
use App\Models\User;
use Illuminate\Http\Request;

class CheckinController extends Controller
{
    protected $estacionamentoService;

    public function __construct(EstacionamentoService $estacionamentoService)
    {
        $this->estacionamentoService = $estacionamentoService;
    }

    public function checkin(Request $request)
    {
        $request->validate([
            'user_id' => 'required|string:exists:users,_id',
            'estacionamento_id' => 'required|string|exists:estacionamentos,_id',
        ]);

        $userId = $request->input('user_id');
        $user = User::find($userId);

        $checkin = new Checkin();
        $checkin->estacionamento_id = $request->input('estacionamento_id');

        $this->estacionamentoService->confirmarEstacionamento($checkin->estacionamento_id);

        $checkin->pin = mt_rand(0100, 9999);

        // Salva o check-in no relacionamento embedsOne do usuário
        $user->checkin()->save($checkin);

        return response()->json([
            'pin' => $checkin->pin,
            'message' => 'Check-in realizado com sucesso',
        ], 200);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'user_id' => 'required|string:exists:users,_id',
            'estacionamento_id' => 'required|string|exists:estacionamentos,_id',
            'pin' => 'required|integer',
        ]);

        $user = User::find($request->input('user_id'));

        if (empty($user->checkin)) {
            return response()->json(['message' => 'Check-in não encontrado'], 404);
        }

        if (empty($user->checkin->pin) || $user->checkin->pin !== $request->input('pin')) {
            return response()->json(['message' => 'PIN inválido'], 403);
        }

        $this->estacionamentoService->liberaEstacionamento($user->checkin->estacionamento_id);

        $user->checkin()->delete();

        return response()->json(['message' => 'Check-out realizado com sucesso'], 200);
    }

}
