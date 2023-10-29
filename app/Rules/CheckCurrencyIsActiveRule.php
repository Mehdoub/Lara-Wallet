<?php

namespace App\Rules;

use App\Models\Currency;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckCurrencyIsActiveRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $currency = Currency::hasKey($value)->first();
        if (!$currency) $fail(__('currency.errors.currency_notfound'));
        else if (!$currency->is_active) $fail(__('currency.errors.currency_is_not_active'));
    }
}
