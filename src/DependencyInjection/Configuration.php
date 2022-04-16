<?php

declare(strict_types=1);


namespace Osonsms\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('osonsms');

        $treeBuilder->getRootNode()
            ->children()
            ->scalarNode('hash')
            ->info('Hash (sha256) of string txn_id+\';\'+login+\';\'+from+\';\'+phone_number+\';\'+pass_salt_hash')
            ->cannotBeEmpty()
            ->end()
            ->scalarNode('from')
            ->info('sender\'s address')
            ->cannotBeEmpty()
            ->end()
            ->scalarNode('login')
            ->info('User login')
            ->cannotBeEmpty()
            ->end()
            ->scalarNode('baseUrl')
            ->info('baseUrl')
            ->cannotBeEmpty()
            ->end();

        return $treeBuilder;
    }
}