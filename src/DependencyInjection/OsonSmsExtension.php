<?php

declare(strict_types=1);

namespace Osonsms\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class OsonSmsExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );
        $loader->load('services.yaml');

        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('osonsms.str_hash', $config['str_hash']);
        $container->setParameter('osonsms.txn_id', $config['txn_id']);
        $container->setParameter('osonsms.from', $config['from']);
        $container->setParameter('osonsms.login', $config['login']);
    }
}
