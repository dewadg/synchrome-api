<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    private $data = [
        [
            'id' => 1,
            'name' => 'su',
            'full_name' => 'Super User',
            'password' => 'supersu',
            'role_id' => 1,
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect($this->data)->each(function ($data) {
            if (is_null(User::find($data['id']))) {
                $password = app('hash')->make($data['password']);

                User::create([
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'full_name' => $data['full_name'],
                    'password' => $password,
                    'role_id' => $data['role_id']
                ]);
            }
        });
    }
}
