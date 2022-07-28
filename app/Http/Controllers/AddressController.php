<?php

namespace App\Http\Controllers;

use App\Services\AddressesService;
use App\Models\Address;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
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

    public function store(Request $request)
    {
        $data = $request->only('cep', 'numero', 'ponto_referencia');
        $validator = Validator::make($data, [
            'cep' => 'required|numeric|min:8',
            'numero' => 'required|numeric|min:1',
            'ponto_referencia' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], Response::HTTP_BAD_REQUEST);
        }


        $response = $this->addressesService->create($data);

        return response()->json($response['result'], $response['http_code']);
        
        // //Request is valid, create new address
        // $address = $this->user->adresses()->create([
        // 	'cep' => $request->cep,
        // 	'numero' => $request->numero,
        // 	'ponto_referencia' => $request->ponto_referencia
        // ]);

        // //Address created, return success response
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Address created successfully',
        //     'data' => $address
        // ], Response::HTTP_OK);
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

    public function update(Request $request, Address $address)
    {
        //Validate data
        $data = $request->only('cep', 'numero', 'ponto_referencia');
        $validator = Validator::make($data, [
            'cep' => 'required|numeric|min:8',
            'numero' => 'required|numeric|min:1',
            'ponto_referencia' => 'required|string',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], Response::HTTP_BAD_REQUEST);
        }

        //Request is valid, update address
        $result = $address->update([
            'cep' => $request->cep,
            'numero' => $request->numero,
            'ponto_referencia' => $request->ponto_referencia
        ]);

        if(!$result) {
            return response()->json([
                'error' => 'Sorry, address cannot be updated'
            ], Response::HTTP_SERVICE_UNAVAILABLE);
        }

        //Product updated, return success response
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
