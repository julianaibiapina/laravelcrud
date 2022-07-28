<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Response;
use App\Repositories\CepsRepository;
use App\Services\CepsService;
use JWTAuth;
use App\Models\Address;

class AddressesService
{
    protected $user;

    public function __construct(CepsRepository $cepsRepository, CepsService $cepsService)
    {
        $this->user = JWTAuth::parseToken()->authenticate();
        $this->cepsRepository = $cepsRepository;
        $this->cepsService = $cepsService;
    }

    public function create(array $data)
    {
        $cep = $this->getCep($data['cep']);

        if(!$cep['success']) {
            return [
                'result' => [
                    'success' => false,
                    'message' => $cep_id['message']
                ],
                'http_code' => Response::HTTP_SERVICE_UNAVAILABLE
            ];
        }

        $endereco = $this->user->adresses()->create([
            'cep_id' => $cep['cep']->id,
            'numero' => $data['numero'],
            'ponto_referencia' => $data['ponto_referencia'],
        ]);

        return [
            'result' => [
                'success' => true,
                'endereco' => $endereco
            ],
            'http_code' => Response::HTTP_OK
        ];
    }


    private function getCep(string $cep_number) : array
    {
        $cep = $this->cepsRepository->find('cep', $cep_number);

        if(!$cep) {
            $cep_info = $this->cepsService->getDadosCep($cep_number);

            if(!$cep_info['success'])
                return $cep_info;
            
            $cep_info = $cep_info['info'];
            $cep = $this->cepsRepository->create([
                'cep' => $cep_number,
                'rua' => $cep_info['logradouro'],
                'bairro' => $cep_info['bairro'],
                'cidade' => $cep_info['localidade'],
                'uf' => $cep_info['uf']
            ]);
        }

        return [
            'success' => true,
            'cep' => $cep
        ];
        
    }
}

