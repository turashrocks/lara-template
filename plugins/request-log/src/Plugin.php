<?php

namespace Botble\RequestLog;

use Artisan;
use Botble\Base\Interfaces\PluginInterface;
use Schema;

class Plugin implements PluginInterface
{

    /**
     * @return array
     * @author Turash Chowdhury
     */
    public static function permissions()
    {
        return [];
    }

    /**
     * @author Turash Chowdhury
     */
    public static function activate()
    {
        Artisan::call('migrate', [
            '--force' => true,
            '--path' => 'plugins/request-log/database/migrations',
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
        Schema::dropIfExists('request_logs');
    }
}