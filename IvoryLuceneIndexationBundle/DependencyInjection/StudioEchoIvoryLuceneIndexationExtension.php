<?php

namespace StudioEchoBundles\IvoryLuceneIndexationBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class StudioEchoIvoryLuceneIndexationExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        // $loader->load('services.yml');

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        // $loader->load('config.xml');

        if (!empty($config)) {
            $this->loadConfig($config, $container);
        }
    } 

    /**
     * Loads configuration
     *
     * @param array                                                   $config    The configuration.
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container The container.
     */
    protected function loadConfig(array $config, ContainerBuilder $container)
    {
        $container
            ->getDefinition('ivory_lucene_indexation')
            ->addMethodCall('setConfig', array($config));
    }
}