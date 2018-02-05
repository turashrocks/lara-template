<?php

namespace Botble\Block\Repositories\Caches;

use Botble\Support\Repositories\Caches\CacheAbstractDecorator;
use Botble\Support\Services\Cache\CacheInterface;
use Botble\Block\Repositories\Interfaces\BlockInterface;

class BlockCacheDecorator extends CacheAbstractDecorator implements BlockInterface
{
    /**
     * @var BlockInterface
     */
    protected $repository;

    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * BlockCacheDecorator constructor.
     * @param BlockInterface $repository
     * @param CacheInterface $cache
     * @author Turash Chowdhury
     */
    public function __construct(BlockInterface $repository, CacheInterface $cache)
    {
        $this->repository = $repository;
        $this->cache = $cache;
    }

    /**
     * @param $name
     * @param $id
     * @return mixed
     * @author Turash Chowdhury
     */
    public function createSlug($name, $id)
    {
        $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
