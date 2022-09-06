<?php

namespace App\Repositories;

use App\Models\Wallet;

class WalletRepository
{
    public function create(array $data): Wallet
    {
        return Wallet::create([
        	'user_id' => $data['user_id'],
        	'amount'  => 0
        ]);
    }

    public function findByUserId(int $user_id): Wallet
    {
        return Wallet::where('user_id', $user_id)->get()->first();
    }

    public function updateAmountByUserId(int $amount, int $user_id)
    {
        return Wallet::where('user_id', $user_id)
            ->update(['amount' => $amount]);
    }
}