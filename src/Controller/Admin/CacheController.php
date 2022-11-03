<?php

namespace Cws\Bundle\SonataCacheManagingBundle\Controller\Admin;

use Cws\Bundle\SonataCacheManagingBundle\Cache\CacheInterface;
use Exception;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Psr\Log\LoggerInterface;
use Sonata\AdminBundle\Admin\Pool;
use Sonata\AdminBundle\Bridge\Exporter\AdminExporter;
use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\AdminBundle\Model\AuditManagerInterface;
use Sonata\AdminBundle\Request\AdminFetcherInterface;
use Sonata\AdminBundle\Util\AdminAclUserManagerInterface;
use Sonata\AdminBundle\Util\AdminObjectAclManipulator;
use Sonata\Exporter\Exporter;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class CacheController
 * @package Cws\Bundle\SonataCacheManagingBundle\Controller\Admin
 */
class CacheController extends CRUDController
{
    public function __construct(private KernelInterface $kernel, private iterable $caches = [])
    {
    }

    public function listAction(Request $request): Response
    {
        $hasLiip = $this->kernel->getContainer()->has('liip_imagine.cache.manager');

        return $this->renderWithExtraParams('@CwsSonataCacheManaging/admin/cache/list.html.twig', [
            'hasLiip' => $hasLiip,
        ]);
    }

    /**
     * @param string $type
     *
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function removeAction(SessionInterface $session, string $type)
    {
        if (is_null($type)) {
            throw $this->createNotFoundException();
        }

        $alertType = 'success';
        $alertMessage = sprintf('Le cache %s a bien été supprimé.', $type);

        try {
            /** @var CacheInterface $handler */
            foreach ($this->caches as $cache) {
                if (!$cache->support($type)) {
                    continue;
                }

                $cache->handle();
            }
        } catch (Exception $e) {
            $alertType = 'danger';
            $alertMessage = sprintf("Une erreur s'est produite lors de la suppression du cache de %s.", $type);
        }

        $session
            ->getFlashBag()
            ->add($alertType, $alertMessage)
        ;

        return $this->redirectToRoute('admin_cws_cache_list');
    }
}
