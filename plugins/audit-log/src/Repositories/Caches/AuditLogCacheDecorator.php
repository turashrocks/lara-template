<?php

namespace Botble\AuditLog\Repositories\Caches;

use Botble\AuditLog\Repositories\Interfaces\AuditLogInterface;
use Botble\Support\Repositories\Caches\CacheAbstractDecorator;
use Botble\Support\Services\Cache\CacheInterface;

/**
 * Class AuditLogCacheDecorator
 * @package Botble\AuditLog\Repositories
 * @author Turash Chowdhury
 * @since 16/09/2016 10:55 AM
 */
class AuditLogCacheDecorator extends CacheAbstractDecorator implements AuditLogInterface
{
    /**
     * @var AuditLogInterface
     */
    protected $repository;

    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * PermissionCacheDecorator constructor.
     * @param AuditLogInterface $repository
     * @param CacheInterface $cache
     * @author Turash Chowdhury
     */
    public function __construct(AuditLogInterface $repository, CacheInterface $cache)
    {
        $this->repository = $repository;
        $this->cache = $cache;
    }
}