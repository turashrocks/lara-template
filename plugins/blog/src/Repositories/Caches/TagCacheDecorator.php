<?php

namespace Botble\Blog\Repositories\Caches;

use Botble\Support\Repositories\Caches\CacheAbstractDecorator;
use Botble\Blog\Repositories\Interfaces\TagInterface;
use Botble\Support\Services\Cache\CacheInterface;

class TagCacheDecorator extends CacheAbstractDecorator implements TagInterface
{

    /**
     * @var TagInterface
     */
    protected $repository;

    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * @var string
     */
    protected $object = 'tags';

    /**
     * TagCacheDecorator constructor.
     * @param TagInterface $repository
     * @param CacheInterface $cache
     * @author Turash Chowdhury
     */
    public function __construct(TagInterface $repository, CacheInterface $cache)
    {
        $this->repository = $repository;
        $this->cache = $cache;
    }

    /**
     * @return mixed
     * @author Turash Chowdhury
     */
    public function getDataSiteMap()
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * @param $limit
     * @return mixed
     * @author Turash Chowdhury
     */
    public function getPopularTags($limit)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * @param bool $active
     * @return mixed
     * @author Turash Chowdhury
     */
    public function getAllTags($active = true)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
