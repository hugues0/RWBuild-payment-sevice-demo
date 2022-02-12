<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Configuration;


class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('configurations')->truncate();

      Configuration::create(['name' => 'vat', 'value' => env('VAT')]);
      Configuration::create(['name' => 'discount', 'value' => env('DISCOUNT')]);
      Configuration::create(['name' => 'transaction_fee','value' => env('TRANSACTION_FEE')]); 
      Configuration::create(['name' => 'coupon', 'value' => env('COUPON_VALUE')]);
      Configuration::create(['name' => 'points_value', 'value' => env('POINTS_VALUE')]);

    }
}
