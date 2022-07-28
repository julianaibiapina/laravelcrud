<?php

namespace App\Services;

use App\Repositories\CepsRepository;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class CepsService
{
    public function __construct()
    {

    }

    public function getDadosCep(string $cep) : array
    {
        $url = str_replace('CEP', $cep, env('CEP_SERVICE_URL'));
        $response = Http::get($url);
        
        if($response->status() != Response::HTTP_OK) {
            return [
                'success' => false,
                'message' => 'Zip consultation service not available'
            ];
        }

        return [
            'success' => true,
            'info' => $response->json()
        ];
    }
}