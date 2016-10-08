<?php

namespace Markup\AddressingBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RegisterAddressFormatExtensionsPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $extensionProviderId = 'markup_addressing.provider.address.extension.internal';
        if (!$container->has($extensionProviderId)) {
            return;
        }

        $provider = $container->getDefinition($extensionProviderId);
        foreach ($container->findTaggedServiceIds('markup_addressing.address_format_extension') as $id => $tags) {
            foreach ($tags as $attributes) {
                if (!isset($attributes['alias'])) {
                    continue;
                }
                $provider->addMethodCall('registerExtension', [$attributes['alias'], new Reference($id)]);
            }
        }
    }
}
