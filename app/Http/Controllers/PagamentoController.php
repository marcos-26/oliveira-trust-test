<?php

namespace App\Http\Controllers;

use App\Domain\Services\PagarMeIntegrationService;
use App\Models\Enum;
use App\Models\Pagamento;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class PagamentoController extends Controller
{
    protected $pagarMeService;

    public function __construct(PagarMeIntegrationService $pagarMeService)
    {
        $this->pagarMeService = $pagarMeService;
    }

    public function realizarPagamento(Request $request)
    {
        // Dados do pagamento recebidos do request
        $dadosPagamento = $request->all();

        // Realizar o pagamento usando o serviço Pagar.me
        $resultadoPagamento = $this->pagarMeService->realizarPagamento($dadosPagamento);

        // Verificar se o pagamento foi bem-sucedido antes de prosseguir
        if ($resultadoPagamento['status'] !== 'success') {
            return response()->json(['message' => 'Falha ao realizar o pagamento'], 400);
        }

        // Recuperar o UUID do pagamento do resultado do pagamento
        $uuid = $dadosPagamento['transaction']['customer']['external_id'];

        // Encontrar o usuário associado ao pagamento pelo UUID
        $user = User::where('pagamento.uuid', $uuid)->first();

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado para o pagamento'], 404);
        }

        // Atualize o status do pagamento no contexto do usuário
        $user->pagamento->status = Enum::SUCESSO->value;
        $user->pagamento->save();

        // Retornar a resposta do pagamento
        return response()->json($resultadoPagamento);
    }


    public function receberPagamento(Request $request)
    {
        $user = User::find($request->input('idUser'));

        if (!$user) {
            return response()->json(['mensagem' => '_id não existe no banco de dados'], 404);
        }

        // Gerar UUID para o pagamento
        $pagamentoData = [
            'uuid' => Uuid::uuid4()->toString(),
            'status' => $request->input('status'),
            'valorTotal' => $request->input('valorTotal'),
            'formaPagamento' => $request->input('formaPagamento'),
            'dataPagamento' => $request->input('dataPagamento'),
        ];

        // Criar o pagamento dentro do contexto do usuário
        $pagamento = $user->pagamento()->create($pagamentoData);

        return response()->json(['message' => 'Pagamento recebido com sucesso', 'pagamento' => $pagamento]);
    }
}
