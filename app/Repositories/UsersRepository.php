<?php

namespace App\Repositories;

use App\Models\User;

class UsersRepository
{
    public function create(array $data)
    {
        return User::create([
        	'name' => $data['name'],
        	'email' => $data['email'],
        	'password' => bcrypt($data['password'])
        ]);
    }
}
