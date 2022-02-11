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

      Configuration::create(['name' => 'vat', 'value' => 0.18]);
      Configuration::create(['name' => 'discount', 'value' => 0.2]);
      Configuration::create(['name' => 'transaction_fee', 'value' => 100]); 
      Configuration::create(['name' => 'coupon', 'value' => 0.02]); 

    }
}
