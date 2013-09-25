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
        //if we already have internal twig options we are making, return
        if ($container->hasParameter('markup_addressing.twig.options.internal')) {
            return;
        }

        //if twig.options (that we are using) hasn't been defined yet, return
        if (!$container->hasParameter('twig.options')) {
            return;
        }

        //make internal twig options using inherited twig options but with auto_reload env option set to true
        $twigOptions = $container->getParameter('twig.options');
        $container->setParameter('markup_addressing.twig.options.internal', array_merge($twigOptions, array('auto_reload' => true)));
    }
}
