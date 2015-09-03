<?php

namespace Everlution\EmailBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class EverlutionEmailExtension extends Extension
{

    /**
     * Loads a specific configuration.
     *
     * @param array            $configs    An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     *
     * @api
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $processedConfig = $this->processConfiguration($configuration, $configs);

        $this->defineServices($container, $processedConfig);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }

    private function defineServices(ContainerBuilder $container, array $processedConfig)
    {
        $container->setAlias('everlution.email.ext.mail_system', $processedConfig['mail_system']);
        $container->setAlias('everlution.email.ext.attachment_locator', $processedConfig['attachment_locator']);
        $container->setAlias('everlution.email.ext.async_stream', $processedConfig['async_stream']);

        $container->setAlias('everlution.email.ext.outbound.message_event.request_processor', $processedConfig['request_transformers']['outbound_message_event']);
        $container->setAlias('everlution.email.ext.inbound.request_processor', $processedConfig['request_transformers']['inbound']);

        $this->defineMessageIdService($container, $processedConfig);
    }

    private function defineMessageIdService(ContainerBuilder $container, array $processedConfig)
    {
        $serviceName = 'everlution.email.ext.message_id_generator';

        if (isset($processedConfig['message_id_generator'])) {
            $container->setAlias($serviceName, $processedConfig['message_id_generator']);
        } else {
            $definition = new Definition('Everlution\EmailBundle\Support\MessageId\UuidBasedGenerator', [
                'domainName' => $processedConfig['domain_name']
            ]);

            $container->setDefinition($serviceName, $definition);
        }
    }

}
