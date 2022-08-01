<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Response;
use App\Repositories\CepsRepository;
use App\Services\CepsService;
use JWTAuth;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class AddressesService
{
    protected $user;

    public function __construct(CepsRepository $cepsRepository, CepsService $cepsService)
    {
        $this->user = JWTAuth::parseToken()->authenticate();
        $this->cepsRepository = $cepsRepository;
        $this->cepsService = $cepsService;
    }

    public function list() : array
    {
        $addresses = Auth::user()->addresses;
        return [
            'success' => true,
            'message' => 'OK',
            'data' => [
                "addresses" => $this->returnListAddressesWithCEP($addresses)
            ],
            'http_code' => Response::HTTP_OK
        ];
        
    }

    public function get($id) : array
    {
        $address = Auth::user()->addresses()->find($id);

        if (!$address) {
            return [
                'success' => false,
                'message' => 'Address not found',
                'data' => [],
                'http_code' => Response::HTTP_NOT_FOUND
            ];
        }

        return [
            'success' => true,
            'message' => 'OK',
            'data' => [
                "address" => $this->returnAddressWithCEP($address)
            ],
            'http_code' => Response::HTTP_OK
        ];
    }

    public function update(array $data, Address $address)  : array
    {
        $result = $address->update($data);

        if(!$result) {
            return [
                'success' => false,
                'message' => 'Address cannot be updated',
                'data' => [],
                'http_code' => Response::HTTP_SERVICE_UNAVAILABLE
            ];
        }

        return [
            'success' => true,
            'message' => 'Address updated successfully',
            'data' => [],
            'http_code' => Response::HTTP_OK
        ];
    }
    public function create(array $data) : array
    {
        $cep = $this->getCep($data['cep']);

        if(!$cep['success']) {
            return [
                'success' => false,
                'message' => $cep_id['message'],
                'data' => [],
                'http_code' => Response::HTTP_SERVICE_UNAVAILABLE
            ];
        }

        $endereco = Auth::user()->addresses()->create([
            'cep_id' => $cep['cep']->id,
            'numero' => $data['numero'],
            'ponto_referencia' => $data['ponto_referencia'],
        ]);

        return [
            'success' => true,
            'message' => 'Address created successfully',
            'data' => [
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

    private function returnListAddressesWithCEP(Collection $addresses) : array
    {
        $result = array ();
        foreach ($addresses as $address) {
            $result[] = $this->returnAddressWithCEP($address);
        }

        return $result;
    }

    private function returnAddressWithCEP(Address $address) : array
    {
        $result = $address->toArray();
        $result['cep'] = $address->cep->toArray();
        return $result;
    }
}

