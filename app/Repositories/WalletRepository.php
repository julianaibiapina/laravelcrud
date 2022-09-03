<?php

namespace App\Repositories;

use App\Models\Wallet;

class WalletRepository
{
    public function create(array $data) : Wallet
    {
        return Wallet::create([
        	'user_id' => $data['user_id'],
        	'amount'  => 0
        ]);
    }
}