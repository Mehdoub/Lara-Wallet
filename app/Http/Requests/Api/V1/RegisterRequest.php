<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $validations = [];

        switch($this->method()) {
            case 'POST':
                $validations['name'] = ['required', 'string', 'min:3', 'max:60'];
                $validations['email'] = ['required', 'email', 'max:60', 'unique:users'];
                $validations['password'] = ['required', 'string', 'min:8', 'max:20'];
                break;
        }

        return $validations;
    }
}
