<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = [
            [
                'name' => 'Dollar',
                'key' => 'dollar',
                'symbol' => '$',
                'iso_code' => 'USD'
            ],
            [
                'name' => 'Yuan',
                'key' => 'yuan',
                'symbol' => '¥',
                'iso_code' => 'CNY'
            ],
            [
                'name' => 'Rial',
                'key' => 'rial',
                'symbol' => '﷼',
                'iso_code' => 'IRR'
            ],
            [
                'name' => 'Pound',
                'key' => 'pound',
                'symbol' => '£',
                'iso_code' => 'GBP'
            ],
        ];

        DB::table('currencies')->insert($currencies);
    }
}
