<?php

namespace Markup\AddressingBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\Kernel;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class MarkupAddressingExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $this->loadLocaleProvider($config, $container);
        $this->loadRequireStrictRegions($config, $container);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $this->setNonSharedServices($container);
        $this->loadCountryPostalCodeOverrides($config, $container);
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    private function loadLocaleProvider(array $config, ContainerBuilder $container)
    {
        $container->setAlias('markup_addressing.locale_provider', $config['locale_provider']);
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    private function loadCountryPostalCodeOverrides(array $config, ContainerBuilder $container)
    {
        if (!isset($config['country_postal_code_regex_overrides']) || !$config['country_postal_code_regex_overrides']) {
            return;
        }
        $overridesProvider = $container->getDefinition('markup_addressing.country_regex_override_provider');
        $overridesProvider->addMethodCall('setOverrideRegexes', array($config['country_postal_code_regex_overrides']));
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    private function loadRequireStrictRegions(array $config, ContainerBuilder $container)
    {
        $container->setParameter('markup_addressing.require_strict_regions', $config['require_strict_regions']);
    }

    private function setNonSharedServices(ContainerBuilder $container)
    {
        $sharedServiceIds = ['markup_addressing.twig.internal'];
        $isLegacy = version_compare(Kernel::VERSION, '2.8', '<');
        foreach ($sharedServiceIds as $sharedServiceId) {
            $definition = $container->getDefinition($sharedServiceId);
            if (!$isLegacy) {
                $definition->setShared(false);
            } else {
                $definition->setScope(ContainerInterface::SCOPE_PROTOTYPE, false);
            }
        }
    }
}
