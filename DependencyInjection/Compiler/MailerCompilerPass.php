<?php

namespace Everlution\EmailBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class MailerCompilerPass implements CompilerPassInterface
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
        $this->addOutboundMessageTransformers($container, $container->getDefinition('everlution.email.outbound.synchronous_mailer'));
        $this->addOutboundMessageTransformers($container, $container->getDefinition('everlution.email.outbound.asynchronous_mailer'));
    }

    /**
     * @param ContainerBuilder $container
     * @param Definition $definition
     */
    protected function addOutboundMessageTransformers(ContainerBuilder $container, Definition $definition)
    {
        foreach ($container->findTaggedServiceIds('everlution.email.outbound_message_transformer') as $id => $attributes) {
            $definition->addMethodCall('addMessageTransformer', array(new Reference($id)));
        }
    }

}
