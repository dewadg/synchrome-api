<?php

use App\Repositories\EchelonRepo;
use App\Repositories\AgencyRepo;
use App\Services\AgencyService;
use Faker\Factory;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use App\Agency;

class AgencyServiceTest extends TestCase
{
    use DatabaseMigrations;

    protected $faker;

    protected $test_agency_service;

    public function setUp()
    {
        parent::setUp();

        $seeder = app(DatabaseSeeder::class);
        $seeder->call('EchelonTypesTableSeeder');
        $seeder->call('EchelonsTableSeeder');
        $seeder->call('AgenciesTableSeeder');

        $this->faker = Factory::create();
        $this->test_agency_service = new AgencyService(new AgencyRepo, new EchelonRepo);
    }

    public function testGet()
    {
        $agencies = $this->test_agency_service->get();

        $this->assertInstanceOf(Collection::class, $agencies);
        $this->assertCount(3, $agencies);
    }

    public function testCreate()
    {
        $mocked_id = $this->faker->name;
        $mocked_name = $this->faker->name;

        $agency = $this->test_agency_service->create([
            'id' => $mocked_id,
            'name' => $mocked_name,
            'head_echelon_id' => '1.1.01',
        ]);

        $this->assertInstanceOf(Agency::class, $agency);
        $this->assertEquals($mocked_id, $agency->id);
        $this->assertEquals($mocked_name, $agency->name);
    }

    public function testFind()
    {
        $mocked_id = $this->faker->name;
        $mocked_name = $this->faker->name;

        $this->test_agency_service->create([
            'id' => $mocked_id,
            'name' => $mocked_name,
        ]);

        $expected = $this->test_agency_service->find($mocked_id);

        $this->assertInstanceOf(Agency::class, $expected);
        $this->assertEquals($mocked_id, $expected->id);
        $this->assertEquals($mocked_name, $expected->name);
    }
}
