<?php

namespace Modules\User\Tests\Permissions;

use Mockery;
use Modules\Core\Tests\BaseTestCase;
use Modules\User\Permissions\PermissionManager;

class PermissionManagerTest extends BaseTestCase
{
    /**
     * @test
     */
    public function it_should_know_if_permissions_are_all_false()
    {
        $modules = $this->getModulesRepositoryMock();
        $this->app->instance('modules', $modules);

        $manager = new PermissionManager();

        $allFalsePermissions = $manager->permissionsAreAllFalse([
            'permission1' => 'false',
            'permission2' => 'false',
            'permission3' => 'false',
            'permission4' => 'false',
        ]);

        $mixedPermissions = $manager->permissionsAreAllFalse([
            'permission1' => 'true',
            'permission2' => 'false',
            'permission3' => 'false',
            'permission4' => 'true',
        ]);

        $this->assertSame(true, $allFalsePermissions);
        $this->assertSame(false, $mixedPermissions);
    }

    /**
     * @test
     */
    public function it_should_clean_permissions()
    {
        $input = [
            'permission1' => 'true',
            'permission2' => 'true',
            'permission3' => 'false',
            'permission4' => 'false',
            'permission5' => 'true'
        ];

        $expected = [
            'permission1' => true,
            'permission2' => true,
            'permission3' => false,
            'permission4' => false,
            'permission5' => true
        ];

        $manager = new PermissionManager();

        $actual = $manager->clean($input);

        $this->assertSame($expected, $actual, "The PermissionManager should clean the permissions and fix their states.");
    }

    protected function getModulesRepositoryMock()
    {
        return Mockery::mock(Repository::class);
    }
}
