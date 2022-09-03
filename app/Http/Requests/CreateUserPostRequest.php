<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserPostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'       => 'required|string',
            'email'      => 'required|email|unique:users',
            'identifier' => 'required|string|unique:users|min:11|max:20',
            'password'   => 'required|string|min:6|max:50',
            'type_id'    => 'required|int|exists:App\Models\TypesUsers,id'
        ];
    }
}
