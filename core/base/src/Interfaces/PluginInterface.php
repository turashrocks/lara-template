<?php

namespace Botble\Base\Interfaces;

interface PluginInterface
{

    /**
     * @return array
     * @author Turash Chowdhury
     */
    public static function permissions();

    /**
     * @author Turash Chowdhury
     */
    public static function activate();

    /**
     * @author Turash Chowdhury
     */
    public static function deactivate();

    /**
     * @author Turash Chowdhury
     */
    public static function remove();
}