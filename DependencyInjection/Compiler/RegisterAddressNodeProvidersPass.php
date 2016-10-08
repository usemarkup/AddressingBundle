<?php

namespace Markup\AddressingBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RegisterAddressNodeProvidersPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $providerFactoryId = 'markup_addressing.address.factory.node.provider';
        if (!$container->has($providerFactoryId)) {
            return;
        }

        $fac = $container->getDefinition($providerFactoryId);
        foreach ($container->findTaggedServiceIds('markup_addressing.address_node_provider') as $id => $tags) {
            foreach ($tags as $attributes) {
                if (!isset($attributes['alias'])) {
                    continue;
                }
                $fac->addMethodCall('registerProvider', [$attributes['alias'], new Reference($id)]);
            }
        }
    }
}
