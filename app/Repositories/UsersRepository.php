<?php

namespace App\Repositories;

use App\Models\User;

class UsersRepository
{
    public function create(array $data) : User
    {
        return User::create([
        	'name'       => $data['name'],
        	'email'      => $data['email'],
        	'identifier' => $data['identifier'],
        	'password'   => bcrypt($data['password']),
            'type_id'    => $data['type_id']
        ]);
    }
}
