<?php

use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Services\RoleService;

class RoleServiceTest extends TestCase
{
    use DatabaseTransactions;

    public function testGet()
    {
        $service = new RoleService;
        $roles = $service->get();

        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $roles);
    }

    public function testCreate()
    {
        $service = new RoleService;
        $role = $service->create([
            'name' => 'User',
            'accesses' => [1],
        ]);

        $this->assertInstanceOf(\App\Role::class, $role);
    }

    public function testFind()
    {
        $service = new RoleService;
        $role = $service->find(1);

        $this->assertInstanceOf(\App\Role::class, $role);
    }

    public function testUpdate()
    {
        $service = new RoleService;

        $updated_role = $service->update(1, [
            'name' => 'Userz',
            'accesses' => [1]
        ]);

        $this->assertTrue($updated_role->name === 'Userz');
    }

    public function testDelete()
    {
        $service = new RoleService;

        $this->assertTrue($service->delete(1));
    }
}
