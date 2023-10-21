<?php

namespace App\Rules;

use App\Models\Currency;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CurrencyCustomRules implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        switch($attribute) {
            case 'currency_id':
                $currency = Currency::find($value);
                if ($currency and !$currency->is_active) $fail(__('currency.errors.currency_is_not_active'));
                break;
        }
    }
}
