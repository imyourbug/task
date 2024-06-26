<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\BaseRequest;

class RecoverRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|regex:/^(.*?)@(.*?)$/',
        ];
    }
}
