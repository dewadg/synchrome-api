<?php

use App\Repositories\RankRepo;
use App\Services\RankService;
use Faker\Factory;
use Laravel\Lumen\Testing\DatabaseMigrations;

class RankServiceTest extends TestCase
{
    use DatabaseMigrations;

    protected $faker;

    protected $test_rank_service;

    public function setUp()
    {
        parent::setUp();

        $this->faker = Factory::create();
        $this->test_rank_service = new RankService(new RankRepo);
    }

    public function testGet()
    {
        for ($i = 0; $i < 3; $i++) {
            $this->test_rank_service->create([
                'id' => str_replace(' ', '', strtolower($this->faker->name)),
                'name' => $this->faker->name,
            ]);
        }

        $ranks = $this->test_rank_service->get();

        $this->assertCount(3, $ranks);
    }

    public function testCreate()
    {
        $mocked_id = str_replace(' ', '', strtolower($this->faker->name));
        $mocked_name = $this->faker->name;

        $rank = $this->test_rank_service->create([
            'id' => $mocked_id,
            'name' => $mocked_name,
        ]);

        $this->assertTrue($rank->id === $mocked_id);
        $this->assertTrue($rank->name === $mocked_name);
    }

    public function testFind()
    {
        $mocked_id = str_replace(' ', '', strtolower($this->faker->name));
        $mocked_name = $this->faker->name;

        $this->test_rank_service->create([
            'id' => $mocked_id,
            'name' => $mocked_name,
        ]);

        $expected = $this->test_rank_service->find($mocked_id);

        $this->assertTrue($expected->id === $mocked_id);
    }

    public function testUpdate()
    {
        $mocked_id = str_replace(' ', '', strtolower($this->faker->name));
        $mocked_name = $this->faker->name;
        $mocked_new_name = $mocked_name . ' ' . $this->faker->name;

        $this->test_rank_service->create([
            'id' => $mocked_id,
            'name' => $mocked_name,
        ]);

        $output = $this->test_rank_service->update($mocked_id, [
            'name' => $mocked_new_name,
        ]);
        
        $this->assertTrue($output);
    }

    public function testDelete()
    {
        $mocked_id = str_replace(' ', '', strtolower($this->faker->name));
        $mocked_name = $this->faker->name;

        $this->test_rank_service->create([
            'id' => $mocked_id,
            'name' => $mocked_name,
        ]);

        $output = $this->test_rank_service->delete($mocked_id);

        $this->assertTrue($output);
    }
}
