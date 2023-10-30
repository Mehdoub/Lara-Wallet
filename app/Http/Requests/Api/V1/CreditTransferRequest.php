<?php

namespace App\Http\Requests\Api\V1;

use App\Rules\CheckCurrencyIsActiveRule;
use Illuminate\Foundation\Http\FormRequest;

class CreditTransferRequest extends FormRequest
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
                $validations['from_user_id'] = ['required', 'numeric', 'exists:users,id'];
                $validations['to_user_id'] = ['required', 'numeric', 'exists:users,id'];
                break;
        }

        return $validations;
    }

    public function messages()
    {
        return [
            'from_user_id.exists' => __('payment.errors.from_user_notfound'),
            'to_user_id.exists' => __('payment.errors.to_user_notfound'),
        ];
    }
}
