<?php

namespace Cws\Bundle\SonataCacheManagingBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Route\RouteCollection;

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
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('remove', 'remove/{type}');
        $collection->clearExcept(['list', 'remove']);

    }
}
