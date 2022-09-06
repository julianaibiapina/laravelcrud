<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Http;
use App\Repositories\WalletRepository;
use App\Models\Wallet;

class WalletService
{
    public function __construct(WalletRepository $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function addValue(int $user_id, int $value)
    {
        $wallet = $this->walletRepository->findByUserId($user_id);
        $new_amount = $wallet->amount + $value;

        $this->walletRepository->updateAmountByUserId($new_amount, $user_id);
    }

    public function subValue(int $user_id, int $value)
    {
        $wallet = $this->walletRepository->findByUserId($user_id);
        $new_amount = $wallet->amount - $value;

        return Wallet::where('user_id', $user_id)
            ->update(['amount' => $new_amount]);
    }
}