<?php

namespace Botble\Member;

use Artisan;
use Botble\Base\Interfaces\PluginInterface;
use Botble\Base\Supports\Commands\Permission;
use Botble\Member\Providers\MemberServiceProvider;
use Schema;

class Plugin implements PluginInterface
{

    /**
     * @return array
     * @author Turash Chowdhury
     */
    public static function permissions()
    {
        return [
            [
                'name' => 'Members',
                'flag' => 'member.list',
                'is_feature' => true,
            ],
            [
                'name' => 'Create',
                'flag' => 'member.create',
                'parent_flag' => 'member.list',
            ],
            [
                'name' => 'Edit',
                'flag' => 'member.edit',
                'parent_flag' => 'member.list',
            ],
            [
                'name' => 'Delete',
                'flag' => 'member.delete',
                'parent_flag' => 'member.list',
            ],
        ];
    }

    /**
     * @author Turash Chowdhury
     */
    public static function activate()
    {
        Permission::registerPermission(self::permissions());
        Artisan::call('migrate', [
            '--force' => true,
            '--path' => 'plugins/member/database/migrations',
        ]);

        Artisan::call('vendor:publish', [
            '--force' => true,
            '--tag' => 'assets',
            '--provider' => MemberServiceProvider::class,
        ]);
    }

    /**
     * @author Turash Chowdhury
     */
    public static function deactivate()
    {

    }

    /**
     * @author Turash Chowdhury
     */
    public static function remove()
    {
        Permission::removePermission(self::permissions());
        Schema::dropIfExists('members');
        Schema::dropIfExists('member_password_resets');
    }
}