<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cep;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'cep_id', 'numero', 'ponto_referencia',
    ];

    public function cep()
    {
        return $this->belongsTo(Cep::class);
    }
}
