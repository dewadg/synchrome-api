<?php

use App\Echelon;
use Illuminate\Database\Seeder;

class EchelonsTableSeeder extends Seeder
{
    private $data = [
        [
            'id' => '1.1.01',
            'echelon_type_id' => '2a',
            'supervisor_id' => null,
            'name' => 'Kepala Biro Pemerintahan dan Otonomi Daerah',
        ],

        [
            'id' => '1.1.01.1',
            'echelon_type_id' => '2b',
            'supervisor_id' => '1.1.01',
            'name' => 'Kepala Bagian Pemerintahan',
        ],
        [
            'id' => '1.1.01.1.1',
            'echelon_type_id' => '3a',
            'supervisor_id' => '1.1.01.1',
            'name' => 'Kepala Sub Bagian Pemerintahan Umum',
        ],
        [
            'id' => '1.1.01.1.2',
            'echelon_type_id' => '3a',
            'supervisor_id' => '1.1.01.1',
            'name' => 'Kepala Sub Bagian Pemerintahan Desa/Kelurahan',
        ],
        [
            'id' => '1.1.01.1.3',
            'echelon_type_id' => '3a',
            'supervisor_id' => '1.1.01.1',
            'name' => 'Kepala Sub Bagian Administrasi Wilayah Pemerintahan dan Pertanahan',
        ],

        [
            'id' => '1.1.01.2',
            'echelon_type_id' => '2b',
            'supervisor_id' => '1.1.01',
            'name' => 'Kepala Bagian Aparatur Pemerintahan dan Otonomi Daerah',
        ],
        [
            'id' => '1.1.01.2.1',
            'echelon_type_id' => '3a',
            'supervisor_id' => '1.1.01.2',
            'name' => 'Kepala Sub Bagian Administrasi Aparatur Kepala Daerah dan Legislatif',
        ],
        [
            'id' => '1.1.01.2.2',
            'echelon_type_id' => '3a',
            'supervisor_id' => '1.1.01.2',
            'name' => 'Kepala Sub Bagian Otonomi Daerah',
        ],
        [
            'id' => '1.1.01.2.3',
            'echelon_type_id' => '3a',
            'supervisor_id' => '1.1.01.2',
            'name' => 'Kepala Sub Bagian Tata Usaha Biro',
        ],

        [
            'id' => '1.1.01.3',
            'echelon_type_id' => '2b',
            'supervisor_id' => '1.1.01',
            'name' => 'Kepala Bagian Kerjasama Pemerintahan',
        ],
        [
            'id' => '1.1.01.3.1',
            'echelon_type_id' => '3a',
            'supervisor_id' => '1.1.01.3',
            'name' => 'Kepala Sub Bagian Kerjasama Antar Daerah',
        ],
        [
            'id' => '1.1.01.3.2',
            'echelon_type_id' => '3a',
            'supervisor_id' => '1.1.01.3',
            'name' => 'Kepala Sub Bagian Kerjasama Badan Usaha/Swasta',
        ],
        [
            'id' => '1.1.01.3.3',
            'echelon_type_id' => '3a',
            'supervisor_id' => '1.1.01.3',
            'name' => 'Kepala Sub Bagian Kerjasama Luar Negeri',
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
            if (is_null(Echelon::find($data['id']))) {
                Echelon::create($data);
            }
        }
    }
}
