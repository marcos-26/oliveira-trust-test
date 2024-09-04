<?php

use App\Http\Controllers\CarroController;
use App\Http\Controllers\EnderecoController;
use App\Http\Controllers\CheckinController;
use App\Http\Controllers\EstacionamentoController;
use App\Http\Controllers\PagamentoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

Route::get('/status', function () {
    return response()->json(['status' => 'ok']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class);
});

// Rota para criar um novo usuário
Route::post('/register', [UserController::class, 'store']);

// Rota para autenticar o usuário e criar um token
Route::post('/login', [UserController::class, 'login']);

// Rota para desautenticar o usuário e invalidar o token
Route::middleware('auth:sanctum')->post('/logout', [UserController::class, 'logout']);

// Rota para fazer o checkin
Route::post('/checkin', [CheckinController::class, 'checkin']);

// Rota para fazer o checkout
Route::post('/checkout', [CheckinController::class, 'checkout']);

// Rotas protegidas por autenticação Sanctum
Route::middleware('auth:sanctum')->group(function () {
    // Rota para listar todos os usuários
    Route::get('/users', [UserController::class, 'index']);

    // Rota para exibir um usuário específico
    Route::get('/users/{id}', [UserController::class, 'show']);

    // Rota para atualizar um usuário existente
    Route::put('/users/{id}', [UserController::class, 'update']);

    // Rota para deletar um usuário
    Route::delete('/users/{id}', [UserController::class, 'destroy']);


    Route::post('/users/save-facial-biometrics', [UserController::class, 'saveFacialBiometrics']);
});

// Rotas CRUD para Endereco
Route::get('/endereco/list', [EnderecoController::class, 'index']);
Route::post('/endereco/create', [EnderecoController::class, 'store']);
Route::get('/endereco/show{id}', [EnderecoController::class, 'show']);
Route::put('/endereco/update{id}', [EnderecoController::class, 'update']);
Route::delete('/endereco/delete{id}', [EnderecoController::class, 'destroy']);

// Rotas para o CRUD de Carro
Route::post('/car/create', [CarroController::class, 'store']);
Route::get('/car/list', [CarroController::class, 'index']);
Route::get('/car/show{id}', [CarroController::class, 'show']);
Route::put('/car/update{id}', [CarroController::class, 'update']);
Route::delete('/car/delete{id}', [CarroController::class, 'destroy']);

// Rotas para o CRUD de Estacionamentos
Route::get('estacionamentos/list', [EstacionamentoController::class, 'index']);
Route::post('estacionamentos/create', [EstacionamentoController::class, 'store']);
Route::get('estacionamentos/show{id}', [EstacionamentoController::class, 'show']);
Route::put('estacionamentos/update{id}', [EstacionamentoController::class, 'update']);
Route::delete('estacionamentos/delete{id}', [EstacionamentoController::class, 'destroy']);
Route::post('estacionamentos/listvagas', [EstacionamentoController::class, 'showVagas']);

Route::post('/pagamento/realizarpagamento', [PagamentoController::class, 'realizarPagamento']);
Route::post('/pagamento/receberpagamento', [PagamentoController::class, 'receberPagamento']);
