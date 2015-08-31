<?php

namespace Everlution\EmailBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('everlution_email');

        $rootNode
            ->children()
                ->scalarNode('domain_name')
                    ->isRequired()
                    ->info('Domain name.')
                ->end()
                ->scalarNode('mail_system')
                    ->isRequired()
                    ->info('Instance of Outbound\MailSystem interface.')
                ->end()
                ->scalarNode('attachment_locator')
                    ->isRequired()
                    ->info('Instance of Attachment\AttachmentLocator interface.')
                ->end()
                ->scalarNode('async_stream')
                    ->isRequired()
                    ->info('Async handling launcher. Must be instance of Support\Stream\Stream!')
                ->end()
                ->scalarNode('message_id_generator')
                    ->defaultValue(null)
                    ->info('Instance of Support\MessageId\Generator interface.')
                ->end()
            ->end();

        return $treeBuilder;
    }

}
