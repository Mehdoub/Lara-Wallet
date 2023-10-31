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
                'iso_code' => 'usd'
            ],
            [
                'name' => 'Yuan',
                'key' => 'yuan',
                'symbol' => '¥',
                'iso_code' => 'cny'
            ],
            [
                'name' => 'Rial',
                'key' => 'rial',
                'symbol' => '﷼',
                'iso_code' => 'irr'
            ],
            [
                'name' => 'Pound',
                'key' => 'pound',
                'symbol' => '£',
                'iso_code' => 'gbp'
            ],
        ];

        DB::table('currencies')->insert($currencies);
    }
}
