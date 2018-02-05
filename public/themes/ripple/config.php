<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Inherit from another theme
    |--------------------------------------------------------------------------
    |
    | Set up inherit from another if the file is not exists,
    | this is work with "layouts", "partials" and "views"
    |
    | [Notice] assets cannot inherit.
    |
     */

    'inherit' => null, //default

    /*
    |--------------------------------------------------------------------------
    | Listener from events
    |--------------------------------------------------------------------------
    |
    | You can hook a theme when event fired on activities
    | this is cool feature to set up a title, meta, default styles and scripts.
    |
    | [Notice] these event can be override by package config.
    |
     */

    'events' => [

        // Before event inherit from package config and the theme that call before,
        // you can use this event to set meta, breadcrumb template or anything
        // you want inheriting.
        'before' => function ($theme) {

        },
        // Listen on event before render a theme,
        // this event should call to assign some assets,
        // breadcrumb template.
        'beforeRenderTheme' => function ($theme) {
            // You may use this event to set up your assets.
            $theme->asset()->container('footer')->usePath()->add('jquery', '/vendor/jquery/dist/jquery.min.js');
            $theme->asset()->container('footer')->usePath()->add('bootstrap-js', 'vendor/bootstrap/dist/js/bootstrap.min.js', ['jquery']);
            $theme->asset()->container('footer')->usePath()->add('overflow-text', 'plugins/overflow-text.js', ['jquery']);
            $theme->asset()->container('footer')->usePath()->add('jquery.parallax', 'plugins/jquery.parallax-1.1.3.js', ['jquery']);
            $theme->asset()->container('footer')->usePath()->add('custom', 'js/custom.min.js', ['jquery']);
            $theme->asset()->container('footer')->usePath()->add('ripple.js', 'js/ripple.js', ['jquery']);
            $theme->asset()->container('footer')->usePath()->add('lightgallery-js', 'js/lightgallery.min.js', ['jquery']);
            $theme->asset()->container('footer')->usePath()->add('imagesloaded', 'js/imagesloaded.pkgd.min.js', ['jquery']);
            $theme->asset()->container('footer')->usePath()->add('masonry', 'js/masonry.pkgd.min.js', ['jquery']);
            $theme->asset()->container('footer')->usePath()->add('sweet-alert-js', 'js/sweetalert.min.js', ['jquery']);

            $theme->asset()->usePath()->add('bootstrap-css', 'vendor/bootstrap/dist/css/bootstrap.min.css');
            $theme->asset()->usePath()->add('font-awesome', 'vendor/font-awesome/css/font-awesome.min.css');
            $theme->asset()->usePath()->add('ionicons', 'plugins/ionicons/css/ionicons.min.css');

            $theme->asset()->usePath()->add('main', 'css/main.css');
            $theme->asset()->usePath()->add('style', 'css/style.min.css');
            $theme->asset()->usePath()->add('ripple.css', 'css/ripple.css');
            $theme->asset()->usePath()->add('lightgallery-css', 'css/lightgallery.min.css');

            if (defined('LANGUAGE_MODULE_SCREEN_NAME') && Language::getCurrentLocaleRTL()) {
                $theme->asset()->usePath()->add('rtl', 'css/rtl.css');
            }

            $theme->composer(['page', 'post', 'index'], function($view) {
                $view->withShortcodes();
            });
        },

        // Listen on event before render a layout,
        // this should call to assign style, script for a layout.
        'beforeRenderLayout' => [

            'default' => function ($theme) {

            },
        ],
    ],
];


