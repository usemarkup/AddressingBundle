<?php

namespace Markup\AddressingBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
* Sets up Twig options for the internal address renderer.
*/
class InternalTwigOptionsCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $internalTwigId = 'markup_addressing.twig.internal';
        if (!$container->hasDefinition($internalTwigId)) {
            return;
        }

        //if twig.options (that we are using) hasn't been defined yet, return
        if (!$container->hasParameter('twig.options')) {
            return;
        }

        $internalTwig = $container->getDefinition($internalTwigId);
        //make internal twig options using inherited twig options but with auto_reload env option set to true
        $twigOptions = $container->getParameter('twig.options');
        $internalTwig->replaceArgument(1, array_merge($twigOptions, ['auto_reload' => true]));
    }
}
