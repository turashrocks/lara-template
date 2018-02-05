<?php

namespace Botble\Setting\Facades;

use Botble\Setting\Setting;
use Illuminate\Support\Facades\Facade;

class SettingFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     * @author Turash Chowdhury
     */
    protected static function getFacadeAccessor()
    {
        return Setting::class;
    }
}
