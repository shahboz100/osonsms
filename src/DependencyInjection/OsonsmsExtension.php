<?php

declare(strict_types=1);


namespace Osonsms\DependencyInjection;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class OsonsmsExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );
        $loader->load('services.yaml');

        $container->setParameter('osonsms.hash', $config['hash']);
        $container->setParameter('osonsms.from', $config['from']);
        $container->setParameter('osonsms.login', $config['login']);
        $container->setParameter('osonsms.baseUrl', $config['baseUrl']);
    }
}