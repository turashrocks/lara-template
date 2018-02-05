<?php

namespace Botble\CustomField\Providers;

use Botble\ACL\Repositories\Interfaces\RoleInterface;
use Botble\ACL\Repositories\Interfaces\UserInterface;
use Botble\Base\Events\SessionStarted;
use Botble\CustomField\Facades\CustomFieldSupportFacade;
use Botble\Page\Repositories\Interfaces\PageInterface;
use Botble\Support\Services\Cache\Cache;
use Botble\Base\Supports\Helper;
use Botble\CustomField\Models\CustomField;
use Botble\CustomField\Models\FieldGroup;
use Botble\CustomField\Models\FieldItem;
use Botble\CustomField\Repositories\Caches\CustomFieldCacheDecorator;
use Botble\CustomField\Repositories\Eloquent\CustomFieldRepository;
use Botble\CustomField\Repositories\Caches\FieldGroupCacheDecorator;
use Botble\CustomField\Repositories\Eloquent\FieldGroupRepository;
use Botble\CustomField\Repositories\Caches\FieldItemCacheDecorator;
use Botble\CustomField\Repositories\Eloquent\FieldItemRepository;
use Botble\CustomField\Repositories\Interfaces\CustomFieldInterface;
use Botble\CustomField\Repositories\Interfaces\FieldGroupInterface;
use Botble\CustomField\Repositories\Interfaces\FieldItemInterface;
use Event;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class CustomFieldServiceProvider extends ServiceProvider
{
    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        Helper::autoload(__DIR__ . '/../../helpers');

        $loader = AliasLoader::getInstance();
        $loader->alias('CustomField', CustomFieldSupportFacade::class);

        if (setting('enable_cache', false)) {
            $this->app->singleton(CustomFieldInterface::class, function () {
                return new CustomFieldCacheDecorator(new CustomFieldRepository(new CustomField()), new Cache($this->app['cache'], CUSTOM_FIELD_CACHE_GROUP));
            });

            $this->app->singleton(FieldGroupInterface::class, function () {
                return new FieldGroupCacheDecorator(new FieldGroupRepository(new FieldGroup()), new Cache($this->app['cache'], CUSTOM_FIELD_CACHE_GROUP));
            });

            $this->app->singleton(FieldItemInterface::class, function () {
                return new FieldItemCacheDecorator(new FieldItemRepository(new FieldItem()), new Cache($this->app['cache'], CUSTOM_FIELD_CACHE_GROUP));
            });
        } else {
            $this->app->singleton(CustomFieldInterface::class, function () {
                return new CustomFieldRepository(new CustomField());
            });

            $this->app->singleton(FieldGroupInterface::class, function () {
                return new FieldGroupRepository(new FieldGroup());
            });

            $this->app->singleton(FieldItemInterface::class, function () {
                return new FieldItemRepository(new FieldItem());
            });
        }
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'custom-field');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $this->mergeConfigFrom(__DIR__ . '/../../config/custom-field.php', 'custom-field');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'custom-field');

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

            $this->publishes([__DIR__ . '/../../resources/views' => resource_path('views/vendor/custom-field')], 'views');
            $this->publishes([__DIR__ . '/../../resources/lang' => resource_path('lang/vendor/custom-field')], 'lang');
            $this->publishes([__DIR__ . '/../../config/custom-field.php' => config_path('custom-field.php')], 'config');

            $this->publishes([__DIR__ . '/../../resources/assets' => resource_path('assets/core/plugins/custom-field')], 'resources');
            $this->publishes([__DIR__ . '/../../public/assets' => public_path('vendor/core/plugins/custom-field')], 'assets');
        }

        $this->app->register(HookServiceProvider::class);
        $this->app->register(EventServiceProvider::class);

        Event::listen(SessionStarted::class, function () {
            dashboard_menu()->registerItem([
                'id' => 'cms-plugins-custom-field',
                'priority' => 5,
                'parent_id' => null,
                'name' => trans('custom-field::custom-field.menu_name'),
                'icon' => 'icon icon-list',
                'url' => route('custom-fields.list'),
                'permissions' => ['custom-fields.list'],
            ]);
        });

        $this->registerUsersFields();
        $this->registerPagesFields();
        $this->registerBlogFields();
    }

    /**
     * @return CustomFieldSupportFacade
     */
    protected function registerUsersFields()
    {
        return CustomFieldSupportFacade::registerRule('other', trans('custom-field::rules.logged_in_user'), 'logged_in_user', function () {
            $users = app(UserInterface::class)->all();
            $userArr = [];
            foreach ($users as $user) {
                $userArr[$user->id] = $user->username . ' - ' . $user->email;
            }

            return $userArr;
        })
            ->registerRule('other', trans('custom-field::rules.logged_in_user_has_role'), 'logged_in_user_has_role', function () {
                $roles = app(RoleInterface::class)->all();
                $rolesArr = [];
                foreach ($roles as $role) {
                    $rolesArr[$role->slug] = $role->name . ' - (' . $role->slug . ')';
                }

                return $rolesArr;
            });
    }

    /**
     * @return CustomFieldSupportFacade
     */
    protected function registerPagesFields()
    {
        return CustomFieldSupportFacade::registerRule('basic', trans('custom-field::rules.page_template'), 'page_template', function () {
            return get_page_templates();
        })
            ->registerRule('basic', trans('custom-field::rules.page'), 'page', function () {
                return app(PageInterface::class)->advancedGet([
                    'select' => [
                        'id',
                        'name',
                    ],
                    'order_by' => [
                        'order' => 'ASC',
                        'created_at' => 'DESC',
                    ],
                ])
                    ->pluck('name', 'id')
                    ->toArray();
            })
            ->registerRule('other', trans('custom-field::rules.model_name'), 'model_name', function () {
                return [
                    PAGE_MODULE_SCREEN_NAME => trans('custom-field::rules.model_name_page'),
                ];
            });
    }

    /**
     * @return CustomFieldSupportFacade
     */
    protected function registerBlogFields()
    {
        if (defined('POST_MODULE_SCREEN_NAME')) {
            $categories = get_categories();

            $categoriesArr = [];
            foreach ($categories as $row) {
                $categoriesArr[$row->id] = $row->indent_text . ' ' . $row->name;
            }

            return CustomFieldSupportFacade::registerRuleGroup('blog')
                ->registerRule('blog', trans('custom-field::rules.category'), CATEGORY_MODULE_SCREEN_NAME, function () use ($categoriesArr) {
                    return $categoriesArr;
                })
                ->registerRule('blog', trans('custom-field::rules.post_with_related_category'), POST_MODULE_SCREEN_NAME . '.post_with_related_category', function () use ($categoriesArr) {
                    return $categoriesArr;
                })
                ->expandRule('other', trans('custom-field::rules.model_name'), 'model_name', function () {
                    return [
                        POST_MODULE_SCREEN_NAME => trans('custom-field::rules.model_name_post'),
                        CATEGORY_MODULE_SCREEN_NAME => trans('custom-field::rules.model_name_category'),
                    ];
                });
        }
    }
}
