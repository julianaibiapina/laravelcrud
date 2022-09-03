<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class TransactionsService
{
    public function __construct()
    {
    }

    public function create(array $data): array
    {
        // validar de o payeer tem saldo disponicel no valor da transferencia

        {
            //bloco de DB::transaction

            // fazer transferencia

            // antes de realmente finalizar, verificar o servico autorizador externo
            // https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6
            
            // em caso se sucesso na transacao, deve ser enviado uma notificacao ao usuario que recebeu dinheiro, criar uma fila de envio de email, pq se nao deu certo enviar devido ao servico terceiro, vai ser reprocessado na fila de envio
        }

        
        return [
            'success' => true,
            'message' => 'OK',
            'data' => [],
            'http_code' => Response::HTTP_CREATED
        ];
    }
}