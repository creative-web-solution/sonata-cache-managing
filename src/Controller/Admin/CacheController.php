<?php

namespace Cws\Bundle\SonataCacheManagingBundle\Controller\Admin;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CacheController
 * @package Cws\Bundle\SonataCacheManagingBundle\Controller\Admin
 */
class CacheController extends CRUDController
{
    public function listAction(Request $request): Response
    {
        $hasLiip = $this->container->has('liip_imagine.cache.manager');

        return $this->renderWithExtraParams('@CwsSonataCacheManaging/admin/cache/list.html.twig', [
            'hasLiip' => $hasLiip,
        ]);
    }

    /**
     * @param string $type
     *
     * @return RedirectResponse
     *
     * @throws \Exception
     */
    public function removeAction(string $type)
    {
        if (is_null($type)) {
            throw $this->createNotFoundException();
        }

        try {
            $this
                ->container
                ->get(sprintf('cws.sonata.cache.managing.%s', $type))
                ->handle()
            ;

            $this
                ->container
                ->get('session')
                ->getFlashBag()
                ->add(
                    'success',
                    sprintf('Le cache %s a bien été supprimé.', $type)
                )
            ;
        } catch (\Exception $e) {
            $this
                ->container
                ->get('session')
                ->getFlashBag()
                ->add(
                    'danger',
                    sprintf("Une erreur s'est produite lors de la suppression du cache de %s.", $type)
                )
            ;
        }

        return $this->redirectToRoute('admin_cws_cache_list');
    }
}
