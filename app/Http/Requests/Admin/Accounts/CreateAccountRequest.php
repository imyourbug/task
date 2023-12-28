<?php

namespace App\Http\Requests\Admin\Accounts;

use App\Http\Requests\BaseRequest;

class CreateAccountRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        dd(1);
        $tel_or_email = $this->tel_or_email;
        $is_email = preg_match('/(@)/', $tel_or_email);
        dd($is_email);

        return [
            'tel_or_email' => 'required|string',
            'password' => 'required|string',
            'role' => 'required|integer|in:0,1',
        ];
    }
}
