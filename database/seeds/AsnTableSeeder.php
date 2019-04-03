<?php

use App\Asn;
use Illuminate\Database\Seeder;

class AsnTableSeeder extends Seeder
{
    private $data = [
        [
            'id' => '123456789',
            'agency_id' => '1.1.01',
            'rank_id' => '1a',
            'echelon_id' => '1.1.01',
            'tpp_id' => 1,
            'workshift_id' => 1,
            'calendar_id' => 1,
            'pin' => '123456789',
            'name' => 'John Doe',
            'phone' => '+6212345678123',
            'address' => 'Sesame Street',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->data as $data) {
            if (is_null(Asn::find($data['id']))) {
                Asn::create($data);
            }
        }
    }
}
