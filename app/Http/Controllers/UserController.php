<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Mail\AuthPin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {
        $request->merge([
            'password' => Hash::make($request->password),
        ]);

        $user = User::create($request->all());
        return response()->json($user, 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'pin');

        // Verifica se o usuário existe na coleção de usuários
        $user = User::where('email', $credentials['email'])->first();

        logger('Tentativa de login', ['email' => $credentials['email']]);

        [$pinTimestamp, $pinValue] = $user->pin;
        $pinExpired = now()->greaterThan($pinTimestamp);

        if (blank($credentials['pin']) || $pinExpired) {
            $user->pin = [
                now()->addMinutes(60),
                str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT)
            ];
            $user->save();

            logger('Novo Pin gerado', ['user_id' => $user->id, $user->pin]);

            Mail::to($user->email)->send(new AuthPin($user->pin[1]));

            return response()->json([
                'message' => 'Um novo PIN foi gerado e enviado para o e-mail do usuário',
            ], 419);
        }

        // Verifica se o usuário existe e se a senha está correta
        if ($pinValue !== $credentials['pin']) {
            logger('PIN inválido', ['user_id' => $user->id]);
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        logger('Usuário autenticado', ['user_id' => $user->id]);

        // Autentica o usuário e gera um token
        $token = $user->createToken($request->userAgent());

        return response()->json([
            'user' => $user,
            'token' => $token->plainTextToken,
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logout realizado com sucesso'], 200);
    }

    public function show($id)
    {
        return User::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json($user, 200);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(null, 204);
    }

    public function saveFacialBiometrics(Request $request)
    {
        $request->validate([
            'biometria_facial' => 'required|string',
        ]);

        $user = $request->user();
        $biometriaFacialBase64 = $request->biometria_facial;

        // Decodifica a imagem em base64 e a salva no armazenamento
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $biometriaFacialBase64));
        $imageName = 'biometria_facial_' . $user->id . '.png';
        Storage::disk('public')->put($imageName, $imageData);

        // Salva o nome do arquivo da biometria facial no usuário
        $user->biometria_facial = $imageName;
        $user->save();

        return response()->json(['message' => 'Biometria facial salva com sucesso'], 200);
    }
}
