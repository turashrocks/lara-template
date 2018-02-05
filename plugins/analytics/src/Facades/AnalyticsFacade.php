<?php

namespace Botble\Analytics\Facades;

use Botble\Analytics\Analytics;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Botble\Analytics\Analytics
 */
class AnalyticsFacade extends Facade
{
    /**
     * @return string
     * @modified Turash Chowdhury
     */
    protected static function getFacadeAccessor()
    {
        return Analytics::class;
    }
}
