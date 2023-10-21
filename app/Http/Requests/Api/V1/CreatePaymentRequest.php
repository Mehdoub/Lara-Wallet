<?php

namespace App\Http\Requests\Api\V1;

use App\Enums\Payment\Currency;
use App\Rules\PaymentCustomRules;
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
            'amount' => ['required', 'numeric'],
            'currency_id' => ['required', 'numeric', 'exists:currencies,id', new PaymentCustomRules],
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
