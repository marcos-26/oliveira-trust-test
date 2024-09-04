<?php

namespace App\Domain\Services;

use App\Domain\Services\PagarMeIntegrationService;
use App\Http\Controllers\PagamentoController;

class PagarmeMockService extends PagarMeIntegrationService
{

    public function realizarPagamento($dados)
    {
        if ($dados['transaction']['customer']['documents'][0]['number'] !== '16159770748') {
            // Simular pagamento com falha

            return [
                'status' => 'failure',
                'message' => 'Falha no pagamento',
                'error' => 'Erro desconhecido',
            ];
        }

        // Simular pagamento bem-sucedido
        return [
            'status' => 'success',
            'message' => 'Pagamento realizado com sucesso',
            'transaction_id' => 'TRANSACTION_ID',
        ];
    }

}
