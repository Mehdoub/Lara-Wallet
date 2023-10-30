<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyStoreRequest extends FormRequest
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
                $validations['name'] = ['required', 'string', 'max:30'];
                $validations['symbol'] = ['required', 'string', 'max:10'];
                $validations['iso_code'] = ['required', 'string', 'max:10'];
                $validations['key'] = ['required', 'string', 'max:30', 'unique:currencies'];
                break;
        }

        return $validations;
    }
}
