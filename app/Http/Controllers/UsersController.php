<?php

namespace App\Http\Controllers;

use JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use App\Services\UsersService;
use App\Models\User;
use App\Http\Requests\CreateUserPostRequest;
use App\Http\Requests\AuthenticateUserPostRequest;
use App\Http\Requests\LogoutUserPostRequest;

class UsersController extends Controller
{
    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }

    public function register(CreateUserPostRequest $request)
    {
        $user = User::create([
        	'name' => $request->name,
        	'email' => $request->email,
        	'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => $user
        ], Response::HTTP_OK);
    }
 
    public function authenticate(AuthenticateUserPostRequest $request)
    {
        $response = $this->usersService->createJwtToken($request->only('email', 'password'));

        return response()->json($response['result'], $response['http_code']);
        
    }
 
    public function logout(LogoutUserPostRequest $request)
    {       
        $response = $this->usersService->invalidateJwtToken($request->token);

        return response()->json($response['result'], $response['http_code']);
    }
 
    public function get_user(GetUserPostRequest $request)
    { 
        $user = JWTAuth::authenticate($request->token);
 
        return response()->json(['user' => $user]);
    }
}
