<?php

namespace App\Http\Requests\Api\V1;

use App\Enums\Payment\Currency;
use App\Rules\CurrencyCustomRules;
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
        $validations = [
            'amount' => ['required', 'numeric', 'min:0', 'not_in:0'],
            'currency_id' => ['required', 'numeric', 'exists:currencies,id', new CurrencyCustomRules],
        ];

        return $validations;
    }

    public function messages()
    {
        return [
            'currency_id.exists' => __('currency.errors.currency_notfound')
        ];
    }
}
