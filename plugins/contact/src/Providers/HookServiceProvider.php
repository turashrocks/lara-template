<?php

namespace Botble\Contact\Providers;

use Auth;
use Illuminate\Support\ServiceProvider;
use Botble\Contact\Repositories\Interfaces\ContactInterface;

class HookServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     * @author Turash Chowdhury
     */
    public function boot()
    {
        add_filter(BASE_FILTER_TOP_HEADER_LAYOUT, [$this, 'registerTopHeaderNotification'], 120);
        add_filter(BASE_FILTER_APPEND_MENU_NAME, [$this, 'getUnReadCount'], 120, 2);
        add_shortcode('contact-form', __('Contact form'), __('Add contact form'), [$this, 'form']);
    }

    /**
     * @param string $options
     * @return string
     * @author Turash Chowdhury
     * @throws \Throwable
     */
    public function registerTopHeaderNotification($options)
    {
        if (Auth::user()->hasPermission('contacts.edit')) {
            $contacts = app(ContactInterface::class)->getUnread(['id', 'name', 'email', 'phone', 'created_at']);

            return $options . view('contact::partials.notification', compact('contacts'))->render();
        }
        return null;
    }

    /**
     * @param $number
     * @param $menu_id
     * @return string
     * @author Turash Chowdhury
     */
    public function getUnreadCount($number, $menu_id)
    {
        if ($menu_id == 'cms-plugins-contact') {
            $unread = app(ContactInterface::class)->countUnread();
            if ($unread > 0) {
                return '<span class="badge badge-success">' . $unread . '</span>';
            }
        }
        return $number;
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function form($shortcode)
    {
        return view('contact::forms.contact', ['header' => $shortcode->header])->render();
    }
}
