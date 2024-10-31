<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|min:5|max:100',
            'username' => 'required|string|min:3|max:50|unique:users,username,' . $this->user()->id,
            'email' => 'required|email|unique:users,email,' . $this->user()->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
?>