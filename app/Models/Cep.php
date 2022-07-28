<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cep extends Model
{
    use HasFactory;

    protected $fillable = [
        'cep', 'rua', 'bairro', 'cidade', 'uf'
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}