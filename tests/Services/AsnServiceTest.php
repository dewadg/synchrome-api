<?php

use App\Repositories\EchelonRepo;
use App\Repositories\AsnRepo;
use App\Services\AsnService;
use Faker\Factory;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use App\Asn;

class AsnServiceTest extends TestCase
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
        $this->test_asn_service = new AsnService(new AsnRepo);
    }

    public function testGet()
    {
        $asns = $this->test_asn_service->get();

        $this->assertInstanceOf(Collection::class, $asns);
        $this->assertCount(1, $asns);
    }

    public function testCreate()
    {
        $mocked_id = $this->faker->name;
        $mocked_agency_id = '1.1.01';
        $mocked_rank_id = '1a';
        $mocked_echelon_id = '1.1.01';
        $mocked_tpp_id = 1;
        $mocked_workshift_id = 1;
        $mocked_calendar_id = 1;
        $mocked_pin = $this->faker->name;
        $mocked_name = $this->faker->name;
        $mocked_phone = $this->faker->e164PhoneNumber;
        $mocked_address = $this->faker->streetAddress;

        $asn = $this->test_asn_service->create([
            'id' => $mocked_id,
            'agency_id' => $mocked_agency_id,
            'rank_id' => $mocked_rank_id,
            'echelon_id' => $mocked_echelon_id,
            'tpp_id' => $mocked_tpp_id,
            'workshift_id' => $mocked_workshift_id,
            'calendar_id' => $mocked_calendar_id,
            'pin' => $mocked_pin,
            'name' => $mocked_name,
            'phone' => $mocked_phone,
            'address' => $mocked_address,
        ]);

        $this->assertInstanceOf(Asn::class, $asn);
        $this->assertEquals($mocked_id, $asn->id);
        $this->assertEquals($mocked_agency_id, $asn->agency_id);
        $this->assertEquals($mocked_rank_id, $asn->rank_id);
        $this->assertEquals($mocked_echelon_id, $asn->echelon_id);
        $this->assertEquals($mocked_tpp_id, $asn->tpp_id);
        $this->assertEquals($mocked_workshift_id, $asn->workshift_id);
        $this->assertEquals($mocked_calendar_id, $asn->calendar_id);
        $this->assertEquals($mocked_pin, $asn->pin);
        $this->assertEquals($mocked_name, $asn->name);
        $this->assertEquals($mocked_phone, $asn->phone);
        $this->assertEquals($mocked_address, $asn->address);
    }

    public function testFind()
    {
        $expected_id = '123456789';
        $actual = $this->test_asn_service->find($expected_id);

        $this->assertInstanceOf(Asn::class, $actual);
        $this->assertEquals($expected_id, $actual->id);
    }

    public function testUpdate()
    {
        $expected_id = '123456789';
        $mocked_agency_id = '1.1.01';
        $mocked_rank_id = '1a';
        $mocked_echelon_id = '1.1.01';
        $mocked_tpp_id = 1;
        $mocked_workshift_id = 1;
        $mocked_calendar_id = 1;
        $mocked_pin = $this->faker->name;
        $mocked_name = $this->faker->name;
        $mocked_phone = $this->faker->e164PhoneNumber;
        $mocked_address = $this->faker->streetAddress;

        $output = $this->test_asn_service->update($expected_id, [
            'agency_id' => $mocked_agency_id,
            'rank_id' => $mocked_rank_id,
            'echelon_id' => $mocked_echelon_id,
            'tpp_id' => $mocked_tpp_id,
            'workshift_id' => $mocked_workshift_id,
            'calendar_id' => $mocked_calendar_id,
            'pin' => $mocked_pin,
            'name' => $mocked_name,
            'phone' => $mocked_phone,
            'address' => $mocked_address,
        ]);

        $this->assertTrue($output);
    }

    public function testDelete()
    {
        $expected_id = '123456789';

        $output = $this->test_asn_service->delete($expected_id);

        $this->assertTrue($output);
    }
}
