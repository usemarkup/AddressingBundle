<?php

namespace Markup\AddressingBundle;

use Markup\AddressingBundle\DependencyInjection\Compiler\InternalTwigOptionsCompilerPass;
use Markup\AddressingBundle\DependencyInjection\Compiler\RegisterAddressFormatExtensionsPass;
use Markup\AddressingBundle\DependencyInjection\Compiler\RegisterAddressNodeProvidersPass;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class MarkupAddressingBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterAddressFormatExtensionsPass());
    }
}
