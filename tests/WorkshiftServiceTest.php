<?php

use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Services\WorkshiftService;

class WorkshiftServiceTest extends TestCase
{
    // use DatabaseTransactions;

    protected $service;

    public function setUp()
    {
        parent::setUp();

        $this->service = new WorkshiftService;
    }

    public function testGet()
    {
        $workshifts = $this->service->get();

        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $workshifts);
    }

    public function testCreate()
    {
        $workshift = $this->service->create([
            'name' => 'Jam Kerja 1',
            'details' => [
                [
                    'index' => 1,
                    'check_in' => '07:00:00',
                    'check_out' => '15:00:00',
                    'active' => true,
                ],
                [
                    'index' => 2,
                    'check_in' => '07:00:00',
                    'check_out' => '15:00:00',
                    'active' => true,
                ],
                [
                    'index' => 3,
                    'check_in' => '07:00:00',
                    'check_out' => '15:00:00',
                    'active' => true,
                ],
                [
                    'index' => 4,
                    'check_in' => '07:00:00',
                    'check_out' => '15:00:00',
                    'active' => true,
                ],
                [
                    'index' => 5,
                    'check_in' => '07:00:00',
                    'check_out' => '13:00:00',
                    'active' => true,
                ],
                [
                    'index' => 6,
                    'check_in' => null,
                    'check_out' => null,
                    'active' => false,
                ],
                [
                    'index' => 7,
                    'check_in' => null,
                    'check_out' => null,
                    'active' => false,
                ],
            ],
        ]);

        $this->assertInstanceOf(\App\Workshift::class, $workshift);
        $this->assertTrue($workshift->details->count() === 7);
    }

    public function testFind()
    {
        $id = 3;
        $workshift = $this->service->find($id);

        $this->assertTrue($workshift->id === $id);
    }

    public function testUpdate()
    {
        $id = 3;
        
        $workshift = $this->service->update($id, [
            'name' => 'Jam Kerja 123',
            'details' => [
                [
                    'index' => 1,
                    'check_in' => '07:00:00',
                    'check_out' => '15:00:00',
                    'active' => false,
                ],
                [
                    'index' => 2,
                    'check_in' => '07:00:00',
                    'check_out' => '15:00:00',
                    'active' => false,
                ],
                [
                    'index' => 3,
                    'check_in' => '07:00:00',
                    'check_out' => '15:00:00',
                    'active' => true,
                ],
                [
                    'index' => 4,
                    'check_in' => '07:00:00',
                    'check_out' => '15:00:00',
                    'active' => false,
                ],
                [
                    'index' => 5,
                    'check_in' => '07:00:00',
                    'check_out' => '13:00:00',
                    'active' => false,
                ],
                [
                    'index' => 6,
                    'check_in' => null,
                    'check_out' => null,
                    'active' => false,
                ],
                [
                    'index' => 7,
                    'check_in' => null,
                    'check_out' => null,
                    'active' => false,
                ],
            ],
        ]);

        $this->assertInstanceOf(\App\Workshift::class, $workshift);
        $this->assertTrue($workshift->details->count() === 7);
        $this->assertTrue($workshift->details
            ->filter(function ($item) {
                return $item->active === true;
            })
            ->count() === 1);
    }

    public function testDelete()
    {
        $id = 3;

        $this->assertTrue($this->service->delete($id));
    }
}
