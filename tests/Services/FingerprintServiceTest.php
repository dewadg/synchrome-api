<?php

use App\Asn;
use App\Fingerprint;
use App\Services\FingerprintService;
use Faker\Factory;
use Laravel\Lumen\Testing\DatabaseMigrations;

class FingerprintServiceTest extends TestCase
{
    use DatabaseMigrations;

    protected $faker;

    protected $test_asn_service;

    public function setUp()
    {
        parent::setUp();

        $seeder = app(DatabaseSeeder::class);
        $seeder->call('AgenciesTableSeeder');
        $seeder->call('RanksTableSeeder');
        $seeder->call('EchelonTypesTableSeeder');
        $seeder->call('EchelonsTableSeeder');
        $seeder->call('TppTableSeeder');
        $seeder->call('WorkshiftsTableSeeder');
        $seeder->call('AttendanceTypesTableSeeder');
        $seeder->call('CalendarsTableSeeder');
        $seeder->call('AsnTableSeeder');

        $this->faker = Factory::create();
        $this->test_fingerprint_service = new FingerprintService;
    }

    public function testRegister()
    {
        $asn = Asn::first();
        $data =[
            'idx' => 1,
            'alg_ver' => 3,
            'template' => $this->faker->name,
        ];

        $actual = $this->test_fingerprint_service->register($asn->id, $data);

        $this->assertInstanceOf(Fingerprint::class, $actual);
        $this->assertEquals($actual->idx, $data['idx']);
        $this->assertEquals($actual->alg_ver, $data['alg_ver']);
        $this->assertEquals($actual->template, $data['template']);
    }

    public function testDelete()
    {
        $asn = Asn::first();
        $data = [
            'idx' => 1,
            'alg_ver' => 3,
            'template' => $this->faker->name,
        ];

        $fingerprint = $this->test_fingerprint_service->register($asn->id, $data);
        $actual = $this->test_fingerprint_service->delete($asn->id, $fingerprint->id);

        $this->assertTrue($actual);
    }
}
