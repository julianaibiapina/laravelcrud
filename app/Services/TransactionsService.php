<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Repositories\UsersRepository;
use App\Repositories\TransactionRepository;
use App\Services\UsersService;
use App\Services\WalletService;
use App\Models\User;

class TransactionsService
{
    public function __construct(UsersRepository $usersRepository, UsersService $usersService, TransactionRepository $transactionRepository, WalletService $walletService)
    {
        $this->usersRepository = $usersRepository;
        $this->transactionRepository = $transactionRepository;
        $this->usersService = $usersService;
        $this->walletService = $walletService;
    }

    public function create(array $data): array
    {
        $can_operate = $this->canRealizeTransaction($data['payer_id'], $data['value']);
        if($can_operate['success']){
            DB::transaction(function () use ($data) {
                
                $this->transactionRepository->create([
                    'value' => $data['value'],
                    'payer_id' => $data['payer_id'],
                    'payee_id' => $data['payee_id']
                ]);

                $this->walletService->subValue($data['payer_id'], $data['value']);

                $this->walletService->addValue($data['payee_id'], $data['value']);
            });
            
            /**
             * Enviar notificacao ao usuario:
             * Criar entidade Notifications, que deve informar o user_id, a mensagem a ser enviada, e o status.
             * Criar um Command, que executa periodicamente o qual lista Notifications com status de erro e reenvia.
             * Pode haver um limite de tentativas para nao acontecer de uma Notifications ficar sempre na fila.
             */

            return [
                'success' => true,
                'message' => "Operation performed successfully.",
                'data' => [],
                'http_code' => Response::HTTP_OK
            ];
        }

        
        return [
            'success' => false,
            'message' => $can_operate['message'],
            'data' => [],
            'http_code' => Response::HTTP_FORBIDDEN
        ];
    }

    private function externalAuthorizingServiceResponse(): bool
    {
        $url = env('EXTERNAL_AUTHORIZING_SERVICE');
        $response = Http::get($url);

        return $response->status() == Response::HTTP_OK;
    }

    private function canRealizeTransaction(int $payer_id, int $transaction_value): array
    {
        if(Auth::user()->id != $payer_id) {
            return [
                'success' => false,
                'message' => 'Only the account owner can make transfers.',
            ];
        };

        if(!$this->hasBalance(Auth::user(), $transaction_value)) {
            return [
                'success' => false,
                'message' => 'The user does not have sufficient account balance to complete the transaction.',
            ];
        }

        if(!$this->externalAuthorizingServiceResponse()) {
            return [
                'success' => false,
                'message' => 'The external authorization service denied the request.',
            ];
        }

        return [
            'success' => true
        ];
    }

    private function hasBalance(User $user, int $transaction_value): bool
    {
        return $user->wallet->amount >= $transaction_value;
    }

}