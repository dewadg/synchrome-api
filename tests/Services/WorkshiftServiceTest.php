<?php

use App\Repositories\WorkshiftRepo;
use App\Services\WorkshiftService;
use Faker\Factory;
use Laravel\Lumen\Testing\DatabaseMigrations;

class WorkshiftServiceTest extends TestCase
{
    use DatabaseMigrations;

    protected $faker;

    protected $test_workshift_service;

    public function setUp()
    {
        parent::setUp();

        $this->faker = Factory::create();
        $this->test_workshift_service = new WorkshiftService(new WorkshiftRepo);
    }

    public function testGet()
    {
        for ($i = 0; $i < 3; $i++) {
            $this->test_workshift_service->create([
                'name' => $this->faker->name,
                'details' => [
                    [
                        'index' => 1,
                        'check_in' => '07:00:00',
                        'check_out' => '16:00:00',
                        'active' => true,
                    ],
                    [
                        'index' => 2,
                        'check_in' => '07:00:00',
                        'check_out' => '16:00:00',
                        'active' => true,
                    ],
                    [
                        'index' => 3,
                        'check_in' => '07:00:00',
                        'check_out' => '16:00:00',
                        'active' => true,
                    ],
                    [
                        'index' => 4,
                        'check_in' => '07:00:00',
                        'check_out' => '16:00:00',
                        'active' => true,
                    ],
                    [
                        'index' => 5,
                        'check_in' => '07:00:00',
                        'check_out' => '16:00:00',
                        'active' => true,
                    ],
                    [
                        'index' => 6,
                        'check_in' => '07:00:00',
                        'check_out' => '16:00:00',
                        'active' => false,
                    ],
                    [
                        'index' => 7,
                        'check_in' => '07:00:00',
                        'check_out' => '16:00:00',
                        'active' => false,
                    ]
                ]
            ]);
        }

        $workshifts = $this->test_workshift_service->get();

        $this->assertCount(3, $workshifts);
    }

    public function testCreate()
    {
        $mocked_name = $this->faker->name;

        $workshift = $this->test_workshift_service->create([
            'name' => $mocked_name,
            'details' => [
                [
                    'index' => 1,
                    'check_in' => '07:00:00',
                    'check_out' => '16:00:00',
                    'active' => true,
                ],
                [
                    'index' => 2,
                    'check_in' => '07:00:00',
                    'check_out' => '16:00:00',
                    'active' => true,
                ],
                [
                    'index' => 3,
                    'check_in' => '07:00:00',
                    'check_out' => '16:00:00',
                    'active' => true,
                ],
                [
                    'index' => 4,
                    'check_in' => '07:00:00',
                    'check_out' => '16:00:00',
                    'active' => true,
                ],
                [
                    'index' => 5,
                    'check_in' => '07:00:00',
                    'check_out' => '16:00:00',
                    'active' => true,
                ],
                [
                    'index' => 6,
                    'check_in' => '07:00:00',
                    'check_out' => '16:00:00',
                    'active' => false,
                ],
                [
                    'index' => 7,
                    'check_in' => '07:00:00',
                    'check_out' => '16:00:00',
                    'active' => false,
                ]
            ]
        ]);

        $this->assertEquals($mocked_name, $workshift->name);
    }

    public function testFind()
    {
        $mocked_name = $this->faker->name;

        $workshift = $this->test_workshift_service->create([
            'name' => $mocked_name,
            'details' => [
                [
                    'index' => 1,
                    'check_in' => '07:00:00',
                    'check_out' => '16:00:00',
                    'active' => true,
                ],
                [
                    'index' => 2,
                    'check_in' => '07:00:00',
                    'check_out' => '16:00:00',
                    'active' => true,
                ],
                [
                    'index' => 3,
                    'check_in' => '07:00:00',
                    'check_out' => '16:00:00',
                    'active' => true,
                ],
                [
                    'index' => 4,
                    'check_in' => '07:00:00',
                    'check_out' => '16:00:00',
                    'active' => true,
                ],
                [
                    'index' => 5,
                    'check_in' => '07:00:00',
                    'check_out' => '16:00:00',
                    'active' => true,
                ],
                [
                    'index' => 6,
                    'check_in' => '07:00:00',
                    'check_out' => '16:00:00',
                    'active' => false,
                ],
                [
                    'index' => 7,
                    'check_in' => '07:00:00',
                    'check_out' => '16:00:00',
                    'active' => false,
                ]
            ]
        ]);

        $expected = $this->test_workshift_service->find($workshift->id);

        $this->assertEquals($workshift->id, $expected->id);
    }

    public function testUpdate()
    {
        $mocked_name = $this->faker->name;
        $mocked_updated_name = $mocked_name . ' ' . $this->faker->name;

        $mocked_details = [
            [
                'index' => 1,
                'check_in' => '07:00:00',
                'check_out' => '16:00:00',
                'active' => true,
            ],
            [
                'index' => 2,
                'check_in' => '07:00:00',
                'check_out' => '16:00:00',
                'active' => true,
            ],
            [
                'index' => 3,
                'check_in' => '07:00:00',
                'check_out' => '16:00:00',
                'active' => true,
            ],
            [
                'index' => 4,
                'check_in' => '07:00:00',
                'check_out' => '16:00:00',
                'active' => true,
            ],
            [
                'index' => 5,
                'check_in' => '07:00:00',
                'check_out' => '16:00:00',
                'active' => true,
            ],
            [
                'index' => 6,
                'check_in' => '07:00:00',
                'check_out' => '16:00:00',
                'active' => false,
            ],
            [
                'index' => 7,
                'check_in' => '07:00:00',
                'check_out' => '16:00:00',
                'active' => false,
            ]
        ];

        $mocked_updated_details = [
            [
                'index' => 1,
                'check_in' => '07:00:00',
                'check_out' => '09:00:00',
                'active' => true,
            ],
            [
                'index' => 2,
                'check_in' => '07:00:00',
                'check_out' => '09:00:00',
                'active' => true,
            ],
            [
                'index' => 3,
                'check_in' => '07:00:00',
                'check_out' => '09:00:00',
                'active' => true,
            ],
            [
                'index' => 4,
                'check_in' => '07:00:00',
                'check_out' => '09:00:00',
                'active' => true,
            ],
            [
                'index' => 5,
                'check_in' => '07:00:00',
                'check_out' => '09:00:00',
                'active' => true,
            ],
            [
                'index' => 6,
                'check_in' => '07:00:00',
                'check_out' => '09:00:00',
                'active' => true,
            ],
            [
                'index' => 7,
                'check_in' => '07:00:00',
                'check_out' => '09:00:00',
                'active' => true,
            ]
        ];

        $workshift = $this->test_workshift_service->create([
            'name' => $mocked_name,
            'details' => $mocked_details,
        ]);

        $output = $this->test_workshift_service->update($workshift->id, [
            'name' => $mocked_updated_name,
            'details' => $mocked_updated_details,
        ]);

        $this->assertTrue($output);
    }

    public function testDelete()
    {
        $mocked_name = $this->faker->name;

        $workshift = $this->test_workshift_service->create([
            'name' => $mocked_name,
            'details' => [
                [
                    'index' => 1,
                    'check_in' => '07:00:00',
                    'check_out' => '16:00:00',
                    'active' => true,
                ],
                [
                    'index' => 2,
                    'check_in' => '07:00:00',
                    'check_out' => '16:00:00',
                    'active' => true,
                ],
                [
                    'index' => 3,
                    'check_in' => '07:00:00',
                    'check_out' => '16:00:00',
                    'active' => true,
                ],
                [
                    'index' => 4,
                    'check_in' => '07:00:00',
                    'check_out' => '16:00:00',
                    'active' => true,
                ],
                [
                    'index' => 5,
                    'check_in' => '07:00:00',
                    'check_out' => '16:00:00',
                    'active' => true,
                ],
                [
                    'index' => 6,
                    'check_in' => '07:00:00',
                    'check_out' => '16:00:00',
                    'active' => false,
                ],
                [
                    'index' => 7,
                    'check_in' => '07:00:00',
                    'check_out' => '16:00:00',
                    'active' => false,
                ]
            ]
        ]);

        $output = $this->test_workshift_service->delete($workshift->id);

        $this->assertTrue($output);
    }
}
