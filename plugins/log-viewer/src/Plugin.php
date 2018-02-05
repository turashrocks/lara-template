<?php

namespace Botble\LogViewer;

use Botble\Base\Interfaces\PluginInterface;
use Botble\Base\Supports\Commands\Permission;

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
                'name' => 'Logs list',
                'flag' => 'logs.list',
                'is_feature' => true,
            ],
            [
                'name' => 'Delete',
                'flag' => 'logs.delete',
                'parent_flag' => 'logs.list',
            ]
        ];
    }

    /**
     * @author Turash Chowdhury
     */
    public static function activate()
    {
        Permission::registerPermission(self::permissions());
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
    }
}