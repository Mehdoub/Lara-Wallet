<?php

namespace App\Jobs;

use App\Exceptions\NotFoundException;
use App\Models\Currency;
use App\Models\Rate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class FetchNavasanRatesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $currencyKeyToIsoCodes = Currency::whereNotIn('iso_code', ['irr'])->pluck('iso_code', 'key')->toArray();
        if (!$currencyKeyToIsoCodes) {
            throw new NotFoundException(__('currency.errors.iso_code_is_empty'));
        }

        $navasanResponse = Http::get(config('settings.global.navasan_base_url'), [
            'api_key' => config('settings.global.navasan_api_key'),
        ]);
        if (!$navasanResponse->ok()) {
            throw new NotFoundException(__('currency.errors.currency_rates_notfound'));
        }

        foreach ($currencyKeyToIsoCodes as $currencyKey => $currencyIsoCode) {
            $navasanItem = $navasanResponse->json($currencyIsoCode);
            if ($navasanItem) {
                Rate::create([
                    'currency_key' => $currencyKey,
                    'rate' => $navasanItem['value'],
                    'rate_currency_key' => 'rial',
                ]);
            }
        }
    }
}
