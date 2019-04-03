<?php

use App\Workshift;
use App\WorkshiftDetail;
use Illuminate\Database\Seeder;

class WorkshiftsTableSeeder extends Seeder
{
    private $data = [
        [
            'id' => 1,
            'name' => 'Normal Workshift',
            'details' => [
                [
                    'index' => 1,
                    'check_in' => '07:00',
                    'check_out' => '16:00',
                    'active' => true,
                ],
                [
                    'index' => 2,
                    'check_in' => '07:00',
                    'check_out' => '16:00',
                    'active' => true,
                ],
                [
                    'index' => 3,
                    'check_in' => '07:00',
                    'check_out' => '16:00',
                    'active' => true,
                ],
                [
                    'index' => 4,
                    'check_in' => '07:00',
                    'check_out' => '16:00',
                    'active' => true,
                ],
                [
                    'index' => 5,
                    'check_in' => '07:00',
                    'check_out' => '16:00',
                    'active' => true,
                ],
                [
                    'index' => 6,
                    'check_in' => '07:00',
                    'check_out' => '16:00',
                    'active' => false,
                ],
                [
                    'index' => 7,
                    'check_in' => '07:00',
                    'check_out' => '16:00',
                    'active' => false,
                ],
            ],
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
            if (is_null(Workshift::find($data['id']))) {
                $workshift = Workshift::create([
                    'id' => $data['id'],
                    'name' => $data['name'],
                ]);

                $details = collect($data['details'])
                    ->map(function ($item) {
                        return new WorkshiftDetail([
                            'index' => $item['index'],
                            'check_in' => $item['check_in'],
                            'check_out' => $item['check_out'],
                            'active' => $item['active'],
                        ]);
                    })
                    ->all();

                $workshift->details()->saveMany($details);
            }
        }
    }
}
