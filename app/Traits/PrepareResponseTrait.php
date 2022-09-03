<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait PrepareResponseTrait
{
    public function prepareResponse(array $data = [], string $message = null, int $statusCode = 200): JsonResponse
    {
        $body = [
            "success" => in_array($statusCode, range(200, 299)) ? true : false,
            "data" => $data,
            "message" => $message
        ];
        return response()->json($body, $statusCode);
    }
}