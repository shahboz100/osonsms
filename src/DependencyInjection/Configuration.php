<?php

declare(strict_types=1);

namespace Osonsms\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('osonsms');

        $treeBuilder->getRootNode()
            ->children()
            ->scalarNode('str_hash')
            ->info('Hash (sha256) of string txn_id+\';\'+login+\';\'+from+\';\'+phone_number+\';\'+pass_salt_hash')
            ->cannotBeEmpty()
            ->end()
            ->scalarNode('txn_id')
            ->info('unique transaction id for each sms. It\'s used to prevent duplicate messages')
            ->cannotBeEmpty()
            ->end()
            ->scalarNode('from')
            ->info('sender\'s address')
            ->cannotBeEmpty()
            ->end()
            ->scalarNode('login')
            ->info('User login')
            ->cannotBeEmpty()
            ->end();

        return $treeBuilder;
    }
}
