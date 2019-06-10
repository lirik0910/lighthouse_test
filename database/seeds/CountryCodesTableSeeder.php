<?php

use App\CountryCode;
use Illuminate\Database\Seeder;

class CountryCodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\CountryCode::create([
            'country' => 'Ukraine',
            'code' => '+380'
        ]);

        App\CountryCode::create([
            'country' => 'Russia',
            'code' => '+7'
        ]);

        App\CountryCode::create([
            'country' => 'Poland',
            'code' => '+48'
        ]);

        App\CountryCode::create([
            'country' => 'Belarus',
            'code' => '+375'
        ]);
    }
}
