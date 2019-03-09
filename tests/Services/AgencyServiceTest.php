<?php

use App\Repositories\EchelonRepo;
use App\Repositories\AgencyRepo;
use App\Services\AgencyService;
use Faker\Factory;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;

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
}
