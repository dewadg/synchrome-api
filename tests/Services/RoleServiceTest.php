<?php

use App\Repositories\AccessRepo;
use App\Repositories\RoleRepo;
use App\Services\RoleService;
use Faker\Factory;
use Laravel\Lumen\Testing\DatabaseMigrations;

class RoleServiceTest extends TestCase
{
    use DatabaseMigrations;

    protected $faker;

    protected $test_role_service;

    public function setUp()
    {
        parent::setUp();

        $seeder = app(DatabaseSeeder::class);
        $seeder->call('AccessesTableSeeder');

        $this->faker = Factory::create();
        $this->test_role_service = new RoleService(new RoleRepo, new AccessRepo);
    }

    public function testGet()
    {
        for ($i = 0; $i < 3; $i++) {
            $this->test_role_service->create([
                'name' => $this->faker->name,
                'accesses' => '*',
            ]);
        }

        $roles = $this->test_role_service->get();

        $this->assertCount(3, $roles);
    }

    public function testCreate()
    {
        $mocked_name = $this->faker->name;

        $role = $this->test_role_service->create([
            'name' => $mocked_name,
            'accesses' => '*',
        ]);

        $accesses = (new AccessRepo)->get();

        $this->assertEquals($mocked_name, $role->name);
        $this->assertCount($role->accesses->count(), $accesses);
    }

    public function testFind()
    {
        $mocked_name = $this->faker->name;

        $role = $this->test_role_service->create([
            'name' => $mocked_name,
            'accesses' => '*',
        ]);

        $expected = $this->test_role_service->find($role->id);

        $this->assertEquals($expected->id, $role->id);
    }

    public function testUpdate()
    {
        $mocked_name = $this->faker->name;
        $mocked_updated_name = $mocked_name . ' ' . $this->faker->name;

        $role = $this->test_role_service->create([
            'name' => $mocked_name,
            'accesses' => '*',
        ]);

        $output = $this->test_role_service->update($role->id, [
            'name' => $mocked_updated_name,
        ]);

        $this->assertTrue($output);
    }

    public function testDelete()
    {
        $mocked_name = $this->faker->name;

        $role = $this->test_role_service->create([
            'name' => $mocked_name,
            'accesses' => '*',
        ]);

        $output = $this->test_role_service->delete($role->id);

        $this->assertTrue($output);
    }
}
