<?php

namespace Everlution\EmailBundle;

use Doctrine\DBAL\Types\Type;
use Everlution\EmailBundle\DependencyInjection\Compiler\InboundMessageProcessorCompilerPass;
use Everlution\EmailBundle\DependencyInjection\Compiler\MailerCompilerPass;
use Everlution\EmailBundle\Doctrine\Type\HeadersType;
use Everlution\EmailBundle\Doctrine\Type\RecipientsType;
use Everlution\EmailBundle\Doctrine\Type\RecipientType;
use Everlution\EmailBundle\Doctrine\Type\TemplateType;
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

    /**
     * Boots the Bundle.
     */
    public function boot()
    {
        $this->registerCustomDoctrineTypes();
    }

    protected function registerCustomDoctrineTypes()
    {
        Type::addType('emailRecipient', RecipientType::class);
        Type::addType('emailRecipients', RecipientsType::class);
        Type::addType('emailHeaders', HeadersType::class);
        Type::addType('emailTemplate', TemplateType::class);
    }

}
