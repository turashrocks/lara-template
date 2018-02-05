<?php

app()['translator']->addJsonPath(__DIR__ . '/../lang');

register_page_template([
    'default' => __('Default')
]);

add_shortcode('google-map', 'Google map', 'Custom map', 'add_google_map_shortcode');

/**
 * @param $shortcode
 * @return mixed
 * @throws \Botble\Theme\Exceptions\UnknownPartialFileException
 */
function add_google_map_shortcode ($shortcode) {
    return Theme::partial('google-map', ['address' => $shortcode->content]);
}

shortcode()->setAdminConfig('google-map', Theme::partial('google-map-admin-config'));

add_shortcode('youtube-video', 'Youtube video', 'Add youtube video', 'add_youtube_video_shortcode');

/**
 * @param $shortcode
 * @return mixed
 * @throws \Botble\Theme\Exceptions\UnknownPartialFileException
 */
function add_youtube_video_shortcode ($shortcode) {
    return Theme::partial('video', ['url' => $shortcode->content]);
}

shortcode()->setAdminConfig('youtube-video', Theme::partial('youtube-admin-config'));

theme_option()->setSection([
    'title' => __('General'),
    'desc' => __('General settings'),
    'id' => 'opt-text-subsection-general',
    'subsection' => true,
    'icon' => 'fa fa-home',
]);

theme_option()->setSection([
    'title' => __('Logo'),
    'desc' => __('Change logo'),
    'id' => 'opt-text-subsection-logo',
    'subsection' => true,
    'icon' => 'fa fa-image',
    'fields' => [
        [
            'id' => 'logo',
            'type' => 'mediaImage',
            'label' => __('Logo'),
            'attributes' => [
                'name' => 'logo',
                'value' => null,
            ],
        ],
    ],
]);

theme_option()->setField([
    'id' => 'copyright',
    'section_id' => 'opt-text-subsection-general',
    'type' => 'text',
    'label' => __('Copyright'),
    'attributes' => [
        'name' => 'copyright',
        'value' => __('© 2018 Tezzeract IT. All right reserved. Designed by Turash'),
        'options' => [
            'class' => 'form-control',
            'placeholder' => __('Change copyright'),
            'data-counter' => 120,
        ]
    ],
    'helper' => __('Copyright on footer of site'),
]);

theme_option()->setArgs(['debug' => true]);