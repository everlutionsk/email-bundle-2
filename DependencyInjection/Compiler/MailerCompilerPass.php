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
        $this->registerOutboundMessageTransformers($container, $container->getDefinition('everlution.email.outbound.synchronous_mailer'));
        $this->registerOutboundMessageTransformers($container, $container->getDefinition('everlution.email.outbound.asynchronous_mailer'));
    }

    /**
     * @param ContainerBuilder $container
     * @param Definition $mailerDefinition
     */
    protected function registerOutboundMessageTransformers(ContainerBuilder $container, Definition $mailerDefinition)
    {
        $transformerTag = 'everlution.email.outbound.message_transformer';

        foreach ($container->findTaggedServiceIds($transformerTag) as $id => $attributes) {
            $mailerDefinition->addMethodCall('addMessageTransformer', array(new Reference($id)));
        }
    }

}
