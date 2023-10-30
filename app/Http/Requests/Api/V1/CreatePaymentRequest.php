<?php

namespace App\Http\Requests\Api\V1;

use App\Rules\CheckCurrencyIsActiveRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CreatePaymentRequest extends FormRequest
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
                $validations['amount'] = ['required', 'numeric', 'min:0', 'not_in:0'];
                $validations['currency_key'] = ['required', 'string', new CheckCurrencyIsActiveRule];
                break;
        }

        return $validations;
    }
}
