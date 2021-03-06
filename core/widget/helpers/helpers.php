<?php

if (!function_exists('register_widget')) {
    /**
     * @param $widget_id
     * @author Turash Chowdhury
     */
    function register_widget($widget_id)
    {
        Widget::registerWidget($widget_id);
    }
}

if (!function_exists('register_sidebar')) {
    /**
     * @param $args
     * @author Turash Chowdhury
     */
    function register_sidebar($args)
    {
        WidgetGroup::setGroup($args);
    }
}

if (!function_exists('remove_sidebar')) {
    /**
     * @param $sidebar_id
     * @author Turash Chowdhury
     */
    function remove_sidebar($sidebar_id)
    {
        WidgetGroup::removeGroup($sidebar_id);
    }
}

if (!function_exists('dynamic_sidebar')) {
    /**
     * @param $sidebar_id
     * @author Turash Chowdhury
     */
    function dynamic_sidebar($sidebar_id)
    {
        return WidgetGroup::group($sidebar_id)->display();
    }
}