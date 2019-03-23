<?php

use App\Echelon;
use App\Repositories\EchelonRepo;
use App\Repositories\EchelonTypeRepo;
use App\Services\EchelonService;
use Faker\Factory;
use Illuminate\Support\Collection;
use Laravel\Lumen\Testing\DatabaseMigrations;

class EchelonServiceTest extends TestCase
{
    use DatabaseMigrations;

    protected $faker;

    protected $test_echelon_service;

    public function setUp()
    {
        parent::setUp();

        $seeder = app(DatabaseSeeder::class);
        $seeder->call('EchelonTypesTableSeeder');
        $seeder->call('EchelonsTableSeeder');

        $this->faker = Factory::create();
        $this->test_echelon_service = new EchelonService(new EchelonRepo, new EchelonTypeRepo);
    }

    public function testGet()
    {
        $echelons = $this->test_echelon_service->get();

        $this->assertInstanceOf(Collection::class, $echelons);
        $this->assertCount(13, $echelons);
    }

    public function testCreate()
    {
        $echelon = $this->test_echelon_service->create([
            'id' => $this->faker->name,
            'name' => $this->faker->name,
            'echelon_type_id' => '3a',
        ]);

        $this->assertInstanceOf(Echelon::class, $echelon);
    }

    public function testFind()
    {
        $expected_id = '1.1.01';
        $echelon = $this->test_echelon_service->find($expected_id);

        $this->assertInstanceOf(Echelon::class, $echelon);
    }

    public function testUpdate()
    {
        $expected_id = '1.1.01';

        $output = $this->test_echelon_service->update($expected_id, [
            'name' => $this->faker->name,
            'echelon_type_id' => '3a',
        ]);

        $this->assertTrue($output);
    }

    public function testDelete()
    {
        $expected_id = '1.1.01.1.1';

        $output = $this->test_echelon_service->delete($expected_id);

        $this->assertTrue($output);
    }
}
