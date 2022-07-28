<?php

namespace App\Services;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class UsersService
{
    public function createJwtToken(array $credentials) : array
    {
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return [
                    'result' => [
                        'success' => false,
                	    'message' => 'Login credentials are invalid.'
                    ],
                    'http_code' => Response::HTTP_BAD_REQUEST
                ];
            }
        } catch (JWTException $e) {
            return [
                'result' => [
                    'success' => false,
                    'message' => 'Could not create token.'
                ],
                'http_code' => Response::HTTP_SERVICE_UNAVAILABLE
            ];
        }

        return [
            'result' => [
                'success' => true,
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
                'result' => [
                    'success' => true,
                    'message' => 'User has been logged out'
                ],
                'http_code' => Response::HTTP_OK                
            ];
        } catch (JWTException $exception) {
            return [
                'result' => [
                    'success' => false,
                    'message' => 'Sorry, user cannot be logged out'
                ],
                'http_code' => Response::HTTP_SERVICE_UNAVAILABLE
            ];
        }
    }
}