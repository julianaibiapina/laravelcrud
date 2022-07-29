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
use JWTAuth;

class AddressController extends Controller
{
    protected $user;

    public function __construct(AddressesService $addressesService)
    {
        $this->user = JWTAuth::parseToken()->authenticate();
        $this->addressesService = $addressesService;
    }

    public function index()
    {
        return $this->user
            ->adresses()
            ->get();
    }

    public function store(StoreAddressPostRequest $request)
    {
        $data = $request->only('cep', 'numero', 'ponto_referencia');

        $response = $this->addressesService->create($data);

        return response()->json($response['result'], $response['http_code']);
    }

    public function show($id)
    {
        $product = $this->user->adresses()->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product not found.'
            ], Response::HTTP_BAD_REQUEST);
        }
    
        return $product;
    }

    public function update(UpdateAddressPostRequest $request, Address $address)
    {
        $data = $request->only('cep', 'numero', 'ponto_referencia');

        $result = $address->update($data);

        if(!$result) {
            return response()->json([
                'error' => 'Sorry, address cannot be updated'
            ], Response::HTTP_SERVICE_UNAVAILABLE);
        }

        return response()->json([
            'success' => true,
            'message' => 'Address updated successfully',
            'data' => $address
        ], Response::HTTP_OK);
    }

    public function destroy(Address $address)
    {
        $address->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Address deleted successfully'
        ], Response::HTTP_OK);
    }
}
