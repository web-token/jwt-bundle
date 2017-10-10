<?php

declare(strict_types=1);

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2017 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace Jose\Bundle\Checker\DependencyInjection\Source;

use Jose\Bundle\JoseFramework\DependencyInjection\Source\SourceInterface;
use Jose\Component\Checker\HeaderCheckerManagerFactory;
use Jose\Component\Signature\JWSLoader as JWSLoaderService;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class HeaderChecker.
 */
final class HeaderChecker implements SourceInterface
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'header_checkers';
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $this->createService($configs[$this->name()], $container);
    }

    /**
     * {@inheritdoc}
     */
    private function createService(array $config, ContainerBuilder $container)
    {
        foreach ($config as $name => $itemConfig) {
            $service_id = sprintf('jose.header_checker.%s', $name);
            $definition = new Definition(JWSLoaderService::class);
            $definition
                ->setFactory([new Reference(HeaderCheckerManagerFactory::class), 'create'])
                ->setArguments([
                    $itemConfig['headers'],
                ])
                ->setPublic($itemConfig['is_public']);

            $container->setDefinition($service_id, $definition);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getNodeDefinition(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode($this->name())
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->booleanNode('is_public')
                                ->info('If true, the service will be public, else private.')
                                ->defaultTrue()
                            ->end()
                            ->arrayNode('headers')
                                ->useAttributeAsKey('name')
                                ->isRequired()
                                ->prototype('scalar')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container, array $config): ?array
    {
        return null;
    }
}
