<?php

namespace Everlution\EmailBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class InboundMessageProcessorCompilerPass implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        $this->registerInboundMessageTransformers($container, $container->getDefinition('everlution.email.inbound.message_processor'));
    }

    /**
     * @param ContainerBuilder $container
     * @param Definition $messageProcessorDefinition
     */
    protected function registerInboundMessageTransformers(ContainerBuilder $container, Definition $messageProcessorDefinition)
    {
        $transformerTag = 'everlution.email.inbound.message_transformer';

        foreach ($container->findTaggedServiceIds($transformerTag) as $id => $attributes) {
            $messageProcessorDefinition->addMethodCall('addMessageTransformer', array(new Reference($id)));
        }
    }

}
