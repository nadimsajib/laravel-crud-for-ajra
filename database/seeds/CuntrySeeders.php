<?php

use Illuminate\Database\Seeder;
use App\Country;
use App\City;

class CuntrySeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries  = [
            [
            'id'         => 1,
            'name'       => 'Bangladesh',
        ],
            [
                'id'         => 2,
                'name'       => 'India',
            ],
        ];
        Country::insert($countries);
        $cities  = [
            [
                'id'         => 1,
                'name'       => 'Dhaka',
                'country_id'       => 1,
            ],
            [
                'id'         => 2,
                'name'       => 'CTG',
                'country_id'       => 1,
            ],
            [
                'id'         => 3,
                'name'       => 'Kolkata',
                'country_id'       => 2,
            ],
            [
                'id'         => 4,
                'name'       => 'Delhi',
                'country_id'       => 2,
            ],
        ];
        City::insert($cities);
    }
}
