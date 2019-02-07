<?php

namespace Cws\Bundle\SonataCacheManagingBundle\Menu;

use Sonata\AdminBundle\Event\ConfigureMenuEvent;

/**
 * Class MenuBuilderListener
 * @package Cws\Bundle\SonataCacheManagingBundle\Menu
 */
class MenuBuilderListener
{
    /**
     * @param ConfigureMenuEvent $event
     */
    public function addMenuItems(ConfigureMenuEvent $event)
    {
        $menu = $event->getMenu();

        $child = $menu->addChild('cache', [
            'label' => 'Cache',
            'route' => 'admin_cws_cache_list',
        ])->setExtras([
            'icon' => '<i class="fa fa-cog"></i>',
        ]);
    }
}
