<?php

register_sidebar([
    'id' => 'top_sidebar',
    'name' => __('Top sidebar'),
    'description' => __('This is top sidebar section'),
]);
register_sidebar([
    'id' => 'footer_sidebar',
    'name' => __('Footer sidebar'),
    'description' => __('This is footer sidebar section'),
]);

require_once __DIR__ . '/../widgets/tags/tags.php';
require_once __DIR__ . '/../widgets/custom-menu/custom-menu.php';
require_once __DIR__ . '/../widgets/recent-posts/recent-posts.php';

register_widget(TagsWidget::class);
register_widget(CustomMenuWidget::class);
register_widget(RecentPostsWidget::class);
