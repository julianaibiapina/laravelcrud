<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTransactionPostRequest;
use App\Traits\PrepareResponseTrait;
use App\Services\TransactionsService;

class TransactionsController extends Controller
{
    use PrepareResponseTrait;

    public function __construct(TransactionsService $transactionsService)
    {
        $this->transactionsService = $transactionsService;
    }

    public function store(StoreTransactionPostRequest $request)
    {
        $result = $this->transactionsService->create($request->all());

        return $this->prepareResponse($result['data'], $result['message'], $result['http_code']);
    }
}
