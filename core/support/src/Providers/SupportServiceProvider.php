<?php

namespace Botble\Support\Providers;

use File;
use Illuminate\Support\ServiceProvider;

class SupportServiceProvider extends ServiceProvider
{
    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * @author Turash Chowdhury
     */
    public function register()
    {
        $this->autoloadHelpers(__DIR__ . '/../../helpers');
    }

    /**
     * @author Turash Chowdhury
     */
    public function boot()
    {

    }

    /**
     * Load module's helpers
     * @param $directory
     * @author Turash Chowdhury
     * @since 2.0
     */
    public function autoloadHelpers($directory)
    {
        $helpers = File::glob($directory . '/*.php');
        foreach ($helpers as $helper) {
            File::requireOnce($helper);
        }
    }
}
