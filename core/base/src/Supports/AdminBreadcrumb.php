<?php

namespace Botble\Base\Supports;

use Breadcrumbs;
use URL;

class AdminBreadcrumb
{
    /**
     * @return string
     * @author Turash Chowdhury
     */
    public function render()
    {
        return Breadcrumbs::render('pageTitle', page_title()->getTitle(false), URL::full());
    }
}