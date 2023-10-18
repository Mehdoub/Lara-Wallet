<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\BadRequestException;
use App\Facades\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CurrencyStoreRequest;
use App\Http\Resources\CurrencyCollection;
use App\Models\Currency;

class CurrencyController extends Controller
{
    public function index()
    {
        $currencies = Currency::where('is_active', 1)->get();

        return Response::message(__('currency.messages.currencies_found'))
            ->data(new CurrencyCollection($currencies))
            ->send();
    }

    public function store(CurrencyStoreRequest $request)
    {
        $newCurrency = Currency::create([
            'name' => $request->name,
            'symbol' => $request->symbol,
            'abbr' => $request->abbr,
        ]);

        return Response::message(__('currency.messages.currency_created'))
            ->data($newCurrency)
            ->send();
    }

    public function activate(Currency $currency)
    {
        if ($currency->is_active) {
            throw new BadRequestException(__('currency.errors.already_activated'));
        }

        $currency->update(['is_active' => true]);

        return Response::message(__('currency.messages.successfully_avtivated'))->send();
    }

    public function deactivate(Currency $currency)
    {
        if (!$currency->is_active) {
            throw new BadRequestException(__('currency.errors.already_deactivated'));
        }

        $currency->update(['is_active' => false]);

        return Response::message(__('currency.messages.successfully_deavtivated'))->send();
    }
}
