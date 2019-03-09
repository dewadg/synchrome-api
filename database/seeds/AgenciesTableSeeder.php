<?php

use App\Agency;
use Illuminate\Database\Seeder;

class AgenciesTableSeeder extends Seeder
{
    private $data = [
        [
            'id' => '1.1.01',
            'name' => 'Biro Pemerintahan dan Otonomi Daerah',
        ],
        [
            'id' => '1.1.02',
            'name' => 'Biro Kesejahteraan Rakyat',
        ],
        [
            'id' => '1.1.03',
            'name' => 'Biro Hukum dan Hak Asasi Manusia',
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
            if (is_null(Agency::find($data['id']))) {
                Agency::create($data);
            }
        }
    }
}
