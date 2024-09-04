<?php

namespace App\Domain\Services;

use PagarMe\Client;

class PagarMeIntegrationService
{
    private $pagarme;

    public function __construct()
    {
        $this->gateway = config('services.pagarme');
        $this->pagarme = new Client($this->gateway['api_key']);
    }

    public static function factory(): PagarMeIntegrationService
    {
        return app()->make(PagarMeIntegrationService::class);
    }

    public function realizarPagamento($request)
    {
        try {

            // Crie uma transação
            $transaction = $this->pagarme->transactions()->create([
                'amount' => $request->input('amount'), // Valor do pagamento
                'payment_method' => 'credit_card', // Método de pagamento (cartão de crédito)
                'card_number' => $request->input('card_number'),
                'card_cvv' => $request->input('card_cvv'),
                'card_expiration_date' => $request->input('card_expiration_date'),
                'card_holder_name' => $request->input('card_holder_name'),
                'customer' => [
                    'external_id' => '1',
                    'name' => 'Nome do Cliente',
                    'type' => 'individual',
                    'country' => 'br',
                    'documents' => [
                        [
                            'type' => 'cpf',
                            'number' => '00000000000',
                        ],
                    ],
                    'phone_numbers' => ['+551199999999'],
                ],
                'billing' => [
                    'name' => 'Nome do Cliente',
                    'address' => [
                        'country' => 'br',
                        'street' => 'Avenida Brigadeiro Faria Lima',
                        'street_number' => '1811',
                        'state' => 'sp',
                        'city' => 'São Paulo',
                        'neighborhood' => 'Jardim Paulistano',
                        'zipcode' => '01451001',
                    ],
                ],
                'shipping' => [
                    'name' => 'Nome do Cliente',
                    'fee' => 1020,
                    'delivery_date' => '2018-09-22',
                    'expedited' => false,
                    'address' => [
                        'country' => 'br',
                        'street' => 'Avenida Brigadeiro Faria Lima',
                        'street_number' => '1811',
                        'state' => 'sp',
                        'city' => 'São Paulo',
                        'neighborhood' => 'Jardim Paulistano',
                        'zipcode' => '01451001',
                    ],
                ],
                'items' => [
                    [
                        'id' => '1',
                        'title' => 'Nome do Produto',
                        'unit_price' => 10000,
                        'quantity' => 1,
                        'tangible' => true,
                    ],
                ],
            ]);

            // Retorne a resposta da transação
            return response()->json($transaction);
        } catch (PagarMeException $e) {
            // Em caso de erro, retorne uma resposta com o código de erro e mensagem
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /** @example mock response */
    protected function mockTeste($code, $message)
    {
        $mock = new MockHandler([
            new MockResponse($code, [], $message),
        ]);
        $handler = HandlerStack::create($mock);
        $this->client = new Client(['handler' => $handler]);
    }
}
