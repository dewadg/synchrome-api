<?php

use Illuminate\Database\Seeder;
use App\Access;

class AccessesTableSeeder extends Seeder
{
    private $data = [
        [
            'id' => 1,
            'name' => 'Users Management',
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
            if (is_null(Access::find($data['id']))) {
                Access::create($data);
            }
        });
    }
}
