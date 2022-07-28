<?php

namespace App\Repositories;

use App\Models\Cep;

class CepsRepository
{
    public function create(array $data)
    {
        return Cep::create($data);
    }

    public function find(string $column, string $value)
    {
        return Cep::where($column, $value)->first();
    }
}