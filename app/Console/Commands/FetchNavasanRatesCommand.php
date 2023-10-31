<?php

namespace App\Console\Commands;

use App\Jobs\FetchNavasanRatesJob;
use Illuminate\Console\Command;

class FetchNavasanRatesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:fetch-navasan-rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will fetch and update currency rates from api';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        FetchNavasanRatesJob::dispatch();
    }
}
