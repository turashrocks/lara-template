<?php

namespace Botble\Base\Supports;

class PageTitle
{
    protected $title;

    /**
     * @param $title
     * @author Turash
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param bool $full
     * @return string
     * @author Turash
     */
    public function getTitle($full = true)
    {
        if (empty($this->title)) {
            return config('cms.base_name');
        }

        if (!$full) {
            return $this->title;
        }

        return $this->title . ' | ' . config('cms.base_name');
    }
}