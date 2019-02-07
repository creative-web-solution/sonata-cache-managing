<?php

namespace Cws\Bundle\SonataCacheManagingBundle\Cache;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class SymfonyCache
 * @package Cws\Bundle\SonataCacheManagingBundle\Cache
 */
class SymfonyCache implements CacheInterface
{
    /** @var KernelInterface */
    private $kernel;

    /**
     * SymfonyCache constructor.
     *
     * @param KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->setKernel($kernel);
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        $application = new Application($this->getKernel());
        $application->setAutoExit(false);

        $input = new ArrayInput([
            'command' => 'cache:clear',
            '--env' => 'prod',
        ]);

        $output = new NullOutput();
        $application->run($input, $output);
    }

    //-------------------
    //     ACCESSORS
    //-------------------

    /**
     * @return KernelInterface
     */
    public function getKernel()
    {
        return $this->kernel;
    }

    /**
     * @param KernelInterface $kernel
     *
     * @return SymfonyCache
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;

        return $this;
    }
}
