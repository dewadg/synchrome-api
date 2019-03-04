<?php

use App\EchelonType;
use Illuminate\Database\Seeder;

class EchelonTypesTableSeeder extends Seeder
{
    private $data = [
        [
            'id' => '1a',
            'name' => 'Ia',
        ],
        [
            'id' => '1b',
            'name' => 'Ib',
        ],
        [
            'id' => '2a',
            'name' => 'IIa',
        ],
        [
            'id' => '2b',
            'name' => 'IIb',
        ],
        [
            'id' => '3a',
            'name' => 'IIIa',
        ],
        [
            'id' => '3b',
            'name' => 'IIIb',
        ],
        [
            'id' => '4a',
            'name' => 'IVa',
        ],
        [
            'id' => '4b',
            'name' => 'IVb',
        ],
        [
            'id' => '5a',
            'name' => 'Va',
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
            if (is_null(EchelonType::find($data['id']))) {
                EchelonType::create($data);
            }
        }
    }
}
