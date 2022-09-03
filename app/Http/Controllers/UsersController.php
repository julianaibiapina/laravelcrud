<?php

namespace App\Http\Controllers;

use JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use App\Services\UsersService;
use App\Repositories\UsersRepository;
use App\Http\Requests\CreateUserPostRequest;
use App\Http\Requests\AuthenticateUserPostRequest;
use App\Http\Requests\LogoutUserPostRequest;
use App\Traits\PrepareResponseTrait;
use Illuminate\Http\JsonResponse;

class UsersController extends Controller
{
    use PrepareResponseTrait;

    public function __construct(UsersService $usersService, UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
        $this->usersService = $usersService;
    }

    public function register(CreateUserPostRequest $request) : JsonResponse
    {
        $result = $this->usersService->create($request->all());

        return $this->prepareResponse($result['data'], $result['message'], $result['http_code']);
    }
 
    public function authenticate(AuthenticateUserPostRequest $request) : JsonResponse
    {
        $result = $this->usersService->createJwtToken($request->only('email', 'password'));

        return $this->prepareResponse($result['data'], $result['message'], $result['http_code']);
        
    }
 
    public function logout(LogoutUserPostRequest $request) : JsonResponse
    {       
        $result = $this->usersService->invalidateJwtToken($request->token);

        return $this->prepareResponse($result['data'], $result['message'], $result['http_code']);
    }
}
