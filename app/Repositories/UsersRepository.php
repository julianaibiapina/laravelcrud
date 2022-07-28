<?php

namespace App\Repositories;

use App\Models\User;

class UsersRepository
{
    public function create(array $data)
    {
        return User::create([
        	'name' => $request->name,
        	'email' => $request->email,
        	'password' => bcrypt($request->password)
        ]);
    }
}
