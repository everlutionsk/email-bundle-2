<?php

namespace Everlution\EmailBundle;

use Everlution\EmailBundle\DependencyInjection\Compiler\InboundMessageProcessorCompilerPass;
use Everlution\EmailBundle\DependencyInjection\Compiler\MailerCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EverlutionEmailBundle extends Bundle
{

    /**
     * Builds the bundle.
     *
     * It is only ever called once when the cache is empty.
     *
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new MailerCompilerPass());
        $container->addCompilerPass(new InboundMessageProcessorCompilerPass());
    }

}
