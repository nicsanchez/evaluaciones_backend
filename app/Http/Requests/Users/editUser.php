<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class editUser extends FormRequest
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
            'data' => 'required|array',
            'data.name' => 'required|string|max:50',
            'data.lastname' => 'required|string|max:50',
            'data.email' => 'required|email|max:50|unique:users,email,'.$this->request->get('data')['id'],
            'data.document' => 'required|numeric|digits_between:6,15|unique:users,document,'.$this->request->get('data')['id'],
            'data.username' => 'required|unique:users,username,'.$this->request->get('data')['id'],
        ];
    }
}
