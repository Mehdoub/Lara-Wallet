<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\Interfaces\Controllers\Api\V1\CurrencyControllerInterface;
use App\Events\CurrencyActivated;
use App\Events\CurrencyDeactivated;
use App\Exceptions\BadRequestException;
use App\Facades\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CurrencyStoreRequest;
use App\Http\Resources\CurrencyCollection;
use App\Models\Currency;

class CurrencyController extends Controller implements CurrencyControllerInterface
{
    public function index()
    {
        $currencies = Currency::isActive()->paginate(config('settings.global.pagination'));

        return Response::message(__('currency.messages.currencies_found'))
            ->data(new CurrencyCollection($currencies))
            ->send();
    }

    public function store(CurrencyStoreRequest $request)
    {
        $newCurrency = Currency::create([
            'key' => $request->key,
            'name' => $request->name,
            'symbol' => $request->symbol,
            'iso_code' => $request->iso_code,
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
        CurrencyActivated::dispatch($currency);

        return Response::message(__('currency.messages.successfully_activated'))->send();
    }

    public function deactivate(Currency $currency)
    {
        if (!$currency->is_active) {
            throw new BadRequestException(__('currency.errors.already_deactivated'));
        }

        $currency->update(['is_active' => false]);
        CurrencyDeactivated::dispatch($currency);

        return Response::message(__('currency.messages.successfully_deactivated'))->send();
    }
}
