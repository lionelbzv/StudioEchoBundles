<?php

namespace StudioEchoBundles\StudioEchoIvoryLuceneIndexationBundle\DependencyInjection;

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
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('studio_echo_ivory_lucene_indexation');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.
        $rootNode
            ->useAttributeAsKey('class_name')
            ->isRequired()
            ->requiresAtLeastOneElement()
            ->info('Class name as key.')
            ->prototype('array')
                ->children()
                    ->scalarNode('ivory_index')
                        ->isRequired()
                        ->info('IvoryBundle config index name.')
                    ->end()
                    ->scalarNode('pk')
                        ->defaultValue('id')
                        ->info('ID column name.')
                    ->end()
                    ->arrayNode('title')
                        ->children()
                            ->floatNode('boost')->min(0)->defaultValue(1)->info('Lucene indexation boost.')->end()
                            ->scalarNode('method')->defaultValue('getTitle')->info('Getter for title value.')->end()
                        ->end()
                    ->end()
                    ->arrayNode('description')
                        ->children()
                            ->floatNode('boost')->min(0)->defaultValue(1)->info('Lucene indexation boost.')->end()
                            ->arrayNode('methods')
                                ->treatNullLike(array())
                                ->prototype('scalar')->end()
                                ->defaultValue(array('getDescription'))
                                ->info('List of getters for description values. If not set, method getDescription will be called.')
                                ->example('[ getSummary, getDescription ]')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
