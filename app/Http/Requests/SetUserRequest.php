<?php

namespace Stmik\Http\Requests;

use Stmik\Http\Requests\Request;

class SetUserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required', // username
            'email' => 'required|email',
            'password_ulang' => 'required_with:password|same:password'
        ];
    }
}
