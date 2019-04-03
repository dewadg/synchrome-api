<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(AccessesTableSeeder::class);
         $this->call(RolesTableSeeder::class);
         $this->call(UsersTableSeeder::class);
         $this->call(AttendanceTypesTableSeeder::class);
         $this->call(EchelonTypesTableSeeder::class);
         $this->call(EchelonsTableSeeder::class);
         $this->call(AgenciesTableSeeder::class);
         $this->call(TppTableSeeder::class);
    }
}
