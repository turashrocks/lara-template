<?php

namespace Botble\Widget\Repositories\Caches;

use Botble\Support\Repositories\Caches\CacheAbstractDecorator;
use Botble\Support\Services\Cache\CacheInterface;
use Botble\Widget\Repositories\Interfaces\WidgetInterface;

class WidgetCacheDecorator extends CacheAbstractDecorator implements WidgetInterface
{
    /**
     * @var WidgetInterface
     */
    protected $repository;

    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * WidgetCacheDecorator constructor.
     * @param WidgetInterface $repository
     * @param CacheInterface $cache
     * @author Turash Chowdhury
     */
    public function __construct(WidgetInterface $repository, CacheInterface $cache)
    {
        $this->repository = $repository;
        $this->cache = $cache;
    }

    /**
     * Get all theme widgets
     * @return mixed
     * @author Turash Chowdhury
     */
    public function getByTheme()
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
