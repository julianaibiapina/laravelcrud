<?php

namespace App\Http\Controllers;

use App\Services\AddressesService;
use App\Models\Address;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\StoreAddressPostRequest;
use App\Http\Requests\UpdateAddressPostRequest;
use Illuminate\Http\JsonResponse;
use App\Traits\PrepareResponseTrait;
use JWTAuth;

class AddressController extends Controller
{
    use PrepareResponseTrait;

    public function __construct(AddressesService $addressesService)
    {
        $this->addressesService = $addressesService;
    }

    public function index() : JsonResponse
    {
        $result = $this->addressesService->list();

        return $this->prepareResponse($result['data'], $result['message'], $result['http_code']);
    }

    public function store(StoreAddressPostRequest $request) : JsonResponse
    {
        $data = $request->only('cep', 'numero', 'ponto_referencia');

        $result = $this->addressesService->create($data);

        return $this->prepareResponse($result['data'], $result['message'], $result['http_code']);
    }

    public function show($id) : JsonResponse
    {
        $result = $this->addressesService->get($id);

        return $this->prepareResponse($result['data'], $result['message'], $result['http_code']);
    }

    public function update(UpdateAddressPostRequest $request, Address $address)  : JsonResponse
    {
        $data = $request->only('cep', 'numero', 'ponto_referencia');
        $result = $this->addressesService->update($data, $address);

        return $this->prepareResponse($result['data'], $result['message'], $result['http_code']);
    }

    public function destroy(Address $address)  : JsonResponse
    {
        $address->delete();
        
        return $this->prepareResponse(message: 'Address deleted successfully', statusCode: Response::HTTP_OK);
    }
}
