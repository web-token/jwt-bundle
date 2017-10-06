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
use Jose\Component\Checker\ClaimCheckerManagerFactory;
use Jose\Component\Signature\JWSLoader as JWSLoaderService;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class JWSLoader.
 */
final class ClaimChecker implements SourceInterface
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'claim_checkers';
    }

    /**
     * {@inheritdoc}
     */
    public function createService(string $name, array $config, ContainerBuilder $container)
    {
        $service_id = sprintf('jose.claim_checker.%s', $name);
        $definition = new Definition(JWSLoaderService::class);
        $definition
            ->setFactory([new Reference(ClaimCheckerManagerFactory::class), 'create'])
            ->setArguments([
                $config['claims'],
            ])
            ->setPublic($config['is_public']);

        $container->setDefinition($service_id, $definition);
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
                            ->arrayNode('claims')
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
