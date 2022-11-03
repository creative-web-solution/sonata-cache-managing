<?php

namespace Cws\Bundle\SonataCacheManagingBundle\Cache;

/**
 * Interface CacheInterface
 * @package Cws\Bundle\SonataCacheManagingBundle\Cache
 */
interface CacheInterface
{
    public function handle();
    public function support(string $type): bool;
}
