<?php

use App\Services\UserService;
use App\Repositories\UserRepo;
use Faker\Factory;
use Laravel\Lumen\Testing\DatabaseMigrations;

class UserServiceTest extends TestCase
{
    use DatabaseMigrations;

    protected $faker;

    protected $test_user_service;

    public function setUp()
    {
        parent::setUp();

        $seeder = app(DatabaseSeeder::class);
        $seeder->call('AccessesTableSeeder');
        $seeder->call('RolesTableSeeder');

        $this->faker = Factory::create();
        $this->test_user_service = new UserService(new UserRepo);
    }

    public function testGet()
    {
        for ($i = 0; $i < 3; $i++) {
            $this->test_user_service->create([
                'name' => str_replace(' ', '', strtolower($this->faker->name)),
                'password' => $this->faker->name,
                'full_name' => $this->faker->name,
                'role_id' => 1,
            ]);
        }

        $users = $this->test_user_service->get();

        $this->assertCount(3, $users);
    }

    public function testCreate()
    {
        $mocked_name = str_replace(' ', '', strtolower($this->faker->name));
        $mocked_password = $this->faker->name;
        $mocked_full_name = $this->faker->name;
        $mocked_role_id = 1;

        $user = $this->test_user_service->create([
            'name' => $mocked_name,
            'password' => $mocked_password,
            'full_name' => $mocked_full_name,
            'role_id' => $mocked_role_id,
        ]);

        $this->assertEquals($mocked_name, $user->name);
        $this->assertEquals($mocked_full_name, $user->full_name);
        $this->assertEquals($mocked_role_id, $user->role->id);
    }

    public function testFind()
    {
        $mocked_name = str_replace(' ', '', strtolower($this->faker->name));
        $mocked_password = $this->faker->name;
        $mocked_full_name = $this->faker->name;
        $mocked_role_id = 1;

        $user = $this->test_user_service->create([
            'name' => $mocked_name,
            'password' => $mocked_password,
            'full_name' => $mocked_full_name,
            'role_id' => $mocked_role_id,
        ]);

        $expected = $this->test_user_service->find($user->id);

        $this->assertEquals($expected->id, $user->id);
    }

    public function testUpdate()
    {
        $mocked_name = str_replace(' ', '', strtolower($this->faker->name));
        $mocked_password = $this->faker->name;
        $mocked_full_name = $this->faker->name;
        $mocked_role_id = 1;
        $mocked_updated_name = $mocked_name . '123';
        $mocked_updated_full_name = $mocked_full_name . ' ' . $this->faker->name;

        $user = $this->test_user_service->create([
            'name' => $mocked_name,
            'password' => $mocked_password,
            'full_name' => $mocked_full_name,
            'role_id' => $mocked_role_id,
        ]);

        $output = $this->test_user_service->update($user->id, [
            'name' => $mocked_updated_name,
            'full_name' => $mocked_updated_full_name,
            'role_id' => $mocked_role_id,
        ]);

        $this->assertTrue($output);
    }

    public function testDelete()
    {
        $mocked_name = str_replace(' ', '', strtolower($this->faker->name));
        $mocked_password = $this->faker->name;
        $mocked_full_name = $this->faker->name;
        $mocked_role_id = 1;

        $user = $this->test_user_service->create([
            'name' => $mocked_name,
            'password' => $mocked_password,
            'full_name' => $mocked_full_name,
            'role_id' => $mocked_role_id,
        ]);

        $output = $this->test_user_service->delete($user->id);

        $this->assertTrue($output);
    }
}
