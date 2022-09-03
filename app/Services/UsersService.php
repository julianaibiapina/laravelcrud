<?php

namespace App\Services;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use App\Repositories\UsersRepository;
use App\Repositories\WalletRepository;
use App\Models\User;

class UsersService
{
    public function __construct(UsersRepository $usersRepository, WalletRepository $walletRepository)
    {
        $this->usersRepository = $usersRepository;
        $this->walletRepository = $walletRepository;
    }

    public function createJwtToken(array $credentials) : array
    {
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return [
                    'success' => false,
                    'message' => 'Login credentials are invalid',
                    'data' => [],
                    'http_code' => Response::HTTP_BAD_REQUEST
                ];
            }
        } catch (JWTException $e) {
            return [
                
                'success' => false,
                'message' => 'Could not create token',
                'data' => [],
                'http_code' => Response::HTTP_SERVICE_UNAVAILABLE
            ];
        }

        return [
            'success' => true,
            'message' => 'Token created successfully',
            'data' => [
                'token' => $token
            ],
            'http_code' => Response::HTTP_OK
        ];
    }

    public function invalidateJwtToken(string $token) : array
    {
        try {
            JWTAuth::invalidate($token);
 
            return [
                'success' => true,
                'message' => 'User has been logged out',
                'data' => [],
                'http_code' => Response::HTTP_OK                
            ];
        } catch (JWTException $exception) {
            return [
                'success' => false,
                'message' => 'Sorry, user cannot be logged out',
                'data' => [],
                'http_code' => Response::HTTP_SERVICE_UNAVAILABLE
            ];
        }
    }

    public function create(array $data) : array
    {
        $user = $this->usersRepository->create($data);
        $wallet = $this->walletRepository->create([
            'user_id' => $user->id
        ]);
        return [
            'success' => true,
            'message' => 'User created successfully',
            'data' => [
                "user" => $user
            ],
            'http_code' => Response::HTTP_CREATED
        ];
    }
}