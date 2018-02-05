<?php

namespace Botble\Blog\Repositories\Interfaces;

use Botble\Support\Repositories\Interfaces\RepositoryInterface;

interface TagInterface extends RepositoryInterface
{

    /**
     * @return mixed
     * @author Turash Chowdhury
     */
    public function getDataSiteMap();

    /**
     * @param $limit
     * @return mixed
     * @author Turash Chowdhury
     */
    public function getPopularTags($limit);

    /**
     * @param bool $active
     * @return mixed
     * @author Turash Chowdhury
     */
    public function getAllTags($active = true);
}
