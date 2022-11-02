<?php

namespace Cws\Bundle\SonataCacheManagingBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Route\RouteCollectionInterface;

/**
 * Class CacheAdmin
 * @package Cws\Bundle\SonataCacheManagingBundle\Admin
 */
final class CacheAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'cache';
    protected $baseRouteName = 'admin_cws_cache';

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection->add('remove', 'remove/{type}');
        $collection->clearExcept(['list', 'remove']);

    }
}
