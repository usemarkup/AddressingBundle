<?php

namespace Markup\AddressingBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('markup_addressing');
        $rootNode = (method_exists(TreeBuilder::class, 'getRootNode'))
            ? $treeBuilder->getRootNode()
            : $treeBuilder->root('markup_addressing');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('locale_provider')
                    ->defaultValue('markup_addressing.locale_provider.default')
                ->end()
                ->arrayNode('country_postal_code_regex_overrides')
                    ->prototype('variable')
                    ->end()
                ->end()
                ->booleanNode('require_strict_regions')
                    ->defaultFalse()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
