<?php

use Illuminate\Database\Seeder;

use App\AttendanceType;

class AttendanceTypesTableSeeder extends Seeder
{
    private $data = [
        [
            'id' => 'H',
            'name' => 'Hadir',
            'status' => true,
            'tpp_paid' => true,
            'meal_allowance_paid' => true,
            'manual_input' => false,
        ],
        [
            'id' => 'A',
            'name' => 'Alpa/Tanpa Keterangan',
            'status' => false,
            'tpp_paid' => false,
            'meal_allowance_paid' => false,
            'manual_input' => false,
        ],
        [
            'id' => 'I',
            'name' => 'Izin',
            'status' => false,
            'tpp_paid' => false,
            'meal_allowance_paid' => false,
            'manual_input' => true,
        ],
        [
            'id' => 'S',
            'name' => 'Sakit',
            'status' => true,
            'tpp_paid' => true,
            'meal_allowance_paid' => false,
            'manual_input' => true,
        ],
        [
            'id' => 'S2',
            'parent_attendance_type_id' => 'S',
            'name' => 'Sakit lebih dari 14 hari tanpa surat keterangan dokter',
            'status' => false,
            'tpp_paid' => false,
            'meal_allowance_paid' => false,
            'manual_input' => true,
        ],
        [
            'id' => 'S3',
            'parent_attendance_type_id' => 'S',
            'name' => 'Sakit lebih dari 14 hari dengan surat keterangan dokter',
            'status' => true,
            'tpp_paid' => true,
            'meal_allowance_paid' => false,
            'manual_input' => true,
        ],
        [
            'id' => 'C',
            'name' => 'Cuti',
            'status' => true,
            'tpp_paid' => true,
            'meal_allowance_paid' => false,
            'manual_input' => true,
        ],
        [
            'id' => 'C2',
            'parent_attendance_type_id' => 'C',
            'name' => 'Cuti besar/Cuti alasan penting/Cuti di luar tanggungan negara/Masa persiapan pensiun',
            'status' => false,
            'tpp_paid' => false,
            'meal_allowance_paid' => false,
            'manual_input' => true,
        ],
        [
            'id' => 'D',
            'name' => 'Dinas/Dinas luar',
            'status' => true,
            'tpp_paid' => true,
            'meal_allowance_paid' => false,
            'manual_input' => true,
        ],
        [
            'id' => 'TB',
            'name' => 'Tugas belajar',
            'status' => false,
            'tpp_paid' => false,
            'meal_allowance_paid' => false,
            'manual_input' => true,
        ],
        [
            'id' => 'DS',
            'name' => 'Dispensasi',
            'status' => true,
            'tpp_paid' => true,
            'meal_allowance_paid' => true,
            'manual_input' => true,
        ],
        [
            'id' => 'TR',
            'name' => 'Training/Diklat (Pribadi)',
            'status' => false,
            'tpp_paid' => false,
            'meal_allowance_paid' => false,
            'manual_input' => true,
        ],
        [
            'id' => 'TR2',
            'parent_attendance_type_id' => 'TR',
            'name' => 'Training/Diklat (Urusan Dinas)',
            'status' => true,
            'tpp_paid' => true,
            'meal_allowance_paid' => false,
            'manual_input' => true,
        ],
        [
            'id' => 'L',
            'name' => 'Libur',
            'status' => false,
            'tpp_paid' => true,
            'meal_allowance_paid' => false,
            'manual_input' => false,
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect($this->data)->each(function ($data) {
            if (is_null(AttendanceType::find($data['id']))) {
                AttendanceType::create($data);
            }
        });
    }
}
