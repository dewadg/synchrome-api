<?php

use App\Tpp;
use Illuminate\Database\Seeder;

class TppTableSeeder extends Seeder
{
    private $data = [
        [
            'id' => 1,
            'name' => 'Jabatan Pimpinan Tinggi Madya',
            'value' => 30000000,
        ],
        [
            'id' => 2,
            'name' => 'Jabatan Pimpinan Tinggi Pratama',
            'value' => 25000000,
        ],
        [
            'id' => 3,
            'name' => 'Direktur Rumah Sakit',
            'value' => 25000000,
        ],
        [
            'id' => 4,
            'name' => 'Jabatan Administrator Golongan IV',
            'value' => 12000000,
        ],
        [
            'id' => 5,
            'name' => 'Jabatan Administrator Golongan III',
            'value' => 9650000,
        ],
        [
            'id' => 6,
            'name' => 'Jabatan Pengawas Golongan III',
            'value' => 6250000,
        ],
        [
            'id' => 7,
            'name' => 'Fungsional Ahli Golongan IV',
            'value' => 5000000,
        ],
        [
            'id' => 8,
            'name' => 'Fungsional Ahli Golongan III',
            'value' => 4200000,
        ],
        [
            'id' => 9,
            'name' => 'Fungsional Keterampilan Golongan III',
            'value' => 3600000,
        ],
        [
            'id' => 10,
            'name' => 'Fungsional Keterampilan Golongan II',
            'value' => 3000000,
        ],
        [
            'id' => 11,
            'name' => 'Pelaksana Golongan IV',
            'value' => 3600000,
        ],
        [
            'id' => 12,
            'name' => 'Pelaksana Golongan III',
            'value' => 3000000,
        ],
        [
            'id' => 13,
            'name' => 'Pelaksana Golongan II',
            'value' => 2400000,
        ],
        [
            'id' => 14,
            'name' => 'Pelaksana Golongan I',
            'value' => 2400000,
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
            if (is_null(Tpp::find($data['id']))) {
                Tpp::create($data);
            }
        }
    }
}
