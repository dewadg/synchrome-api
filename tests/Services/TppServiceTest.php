<?php

use App\Repositories\TppRepo;
use App\Services\TppService;
use Faker\Factory;
use Laravel\Lumen\Testing\DatabaseMigrations;

class TppServiceTest extends TestCase
{
    use DatabaseMigrations;

    protected $faker;

    protected $test_tpp_service;

    public function setUp()
    {
        parent::setUp();

        $seeder = app(DatabaseSeeder::class);
        $seeder->call('TppTableSeeder');

        $this->faker = Factory::create();
        $this->test_tpp_service = new TppService(new TppRepo);
    }

    public function testGet()
    {
        $tpps = $this->test_tpp_service->get();

        $this->assertCount(14, $tpps);
    }

    public function testCreate()
    {
        $mocked_name = $this->faker->name;
        $mocked_value = $this->faker->numberBetween(1000000, 10000000);

        $tpp = $this->test_tpp_service->create([
            'name' => $mocked_name,
            'value' => $mocked_value,
        ]);

        $this->assertEquals($mocked_name, $tpp->name);
        $this->assertEquals($mocked_value, $tpp->value);
    }

    public function testFind()
    {
        $expected_id = 1;
        $actual = $this->test_tpp_service->find($expected_id);

        $this->assertEquals($actual->id, $expected_id);
        $this->assertEquals($actual->name, 'Jabatan Pimpinan Tinggi Madya');
        $this->assertEquals($actual->value, 30000000);
    }

    public function testUpdate()
    {
        $expected_id = 1;
        $mocked_updated_name = $this->faker->name;
        $mocked_updated_value = $this->faker->numberBetween(5000, 10000);

        $output = $this->test_tpp_service->update($expected_id, [
            'name' => $mocked_updated_name,
            'value' => $mocked_updated_value,
        ]);

        $this->assertTrue($output);
    }

    public function testDelete()
    {
        $expected_id = 1;

        $output = $this->test_tpp_service->delete($expected_id);

        $this->assertTrue($output);
    }
}
