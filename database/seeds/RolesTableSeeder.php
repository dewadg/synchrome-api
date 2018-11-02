<?php

use Illuminate\Database\Seeder;
use App\Access;
use App\Role;

class RolesTableSeeder extends Seeder
{
    private $data = [
        [
            'id' => 1,
            'name' => 'SU',
            'accesses' => '*',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accesses = Access::get(['id'])
            ->map(function ($item) {
                return $item->id;
            })
            ->all();

        collect($this->data)->each(function ($data) use ($accesses) {
            if (is_null(Role::find($data['id']))) {
                $role = Role::create([
                   'id' => $data['id'],
                   'name' => $data['name'],
                ]);

                if ($data['accesses'] === '*') {
                    $role->accesses()->sync($accesses);
                } else {
                    $role->accesses()->sync($data['accesses']);
                }
            }
        });
    }
}
