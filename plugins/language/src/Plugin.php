<?php

namespace Botble\Language;

use Artisan;
use Botble\Base\Interfaces\PluginInterface;
use Botble\Base\Supports\Commands\Permission;
use Botble\Language\Providers\LanguageServiceProvider;
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
                'name' => 'Languages',
                'flag' => 'languages.list',
                'is_feature' => true,
            ],
            [
                'name' => 'Create',
                'flag' => 'languages.create',
                'parent_flag' => 'languages.list',
            ],
            [
                'name' => 'Edit',
                'flag' => 'languages.edit',
                'parent_flag' => 'languages.list',
            ],
            [
                'name' => 'Delete',
                'flag' => 'languages.delete',
                'parent_flag' => 'languages.list',
            ]
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
            '--path' => 'plugins/language/database/migrations',
        ]);

        Artisan::call('vendor:publish', [
            '--force' => true,
            '--tag' => 'assets',
            '--provider' => LanguageServiceProvider::class,
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

        Schema::dropIfExists('languages');
        Schema::dropIfExists('language_meta');
    }
}