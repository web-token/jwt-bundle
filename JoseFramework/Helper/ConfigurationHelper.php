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

namespace Jose\Bundle\JoseFramework\Helper;

use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * This helper will help you to create services configuration.
 */
final class ConfigurationHelper
{
    const BUNDLE_ALIAS = 'jose';

    /**
     * @param ContainerBuilder $container
     * @param string           $name
     * @param string[]         $signatureAlgorithms
     * @param bool             $is_public
     */
    public static function addJWSBuilder(ContainerBuilder $container, string $name, array $signatureAlgorithms, bool $is_public = true)
    {
        $config = [
            self::BUNDLE_ALIAS => [
                'jws_builders' => [
                    $name => [
                        'is_public' => $is_public,
                        'signature_algorithms' => $signatureAlgorithms,
                    ],
                ],
            ],
        ];
        self::updateJoseConfiguration($container, $config, 'jws_builders');
    }

    /**
     * @param ContainerBuilder $container
     * @param string           $name
     * @param string[]         $signatureAlgorithms
     * @param string[]         $headerCheckers
     * @param string[]         $serializers
     * @param bool             $is_public
     */
    public static function addJWSLoader(ContainerBuilder $container, string $name, array $signatureAlgorithms, array  $headerCheckers, array $serializers = ['jws_compact'], bool $is_public = true)
    {
        $config = [
            self::BUNDLE_ALIAS => [
                'jws_loaders' => [
                    $name => [
                        'is_public' => $is_public,
                        'signature_algorithms' => $signatureAlgorithms,
                        'header_checkers' => $headerCheckers,
                        'serializers' => $serializers,
                    ],
                ],
            ],
        ];

        self::updateJoseConfiguration($container, $config, 'jws_loaders');
    }

    /**
     * @param ContainerBuilder $container
     * @param string           $name
     * @param string[]         $claimCheckers
     * @param bool             $is_public
     */
    public static function addClaimChecker(ContainerBuilder $container, string $name, array  $claimCheckers, bool $is_public = true)
    {
        $config = [
            self::BUNDLE_ALIAS => [
                'claim_checkers' => [
                    $name => [
                        'is_public' => $is_public,
                        'claims' => $claimCheckers,
                    ],
                ],
            ],
        ];

        self::updateJoseConfiguration($container, $config, 'claim_checkers');
    }

    /**
     * @param ContainerBuilder $container
     * @param string           $name
     * @param string           $type
     * @param array            $parameters
     */
    public static function addKey(ContainerBuilder $container, string $name, string $type, array  $parameters)
    {
        $config = [
            self::BUNDLE_ALIAS => [
                'keys' => [
                    $name => [
                        $type => $parameters,
                    ],
                ],
            ],
        ];

        self::updateJoseConfiguration($container, $config, 'keys');
    }

    /**
     * @param ContainerBuilder $container
     * @param string           $name
     * @param string           $type
     * @param array            $parameters
     */
    public static function addKeyset(ContainerBuilder $container, string $name, string $type, array  $parameters)
    {
        $config = [
            self::BUNDLE_ALIAS => [
                'key_sets' => [
                    $name => [
                        $type => $parameters,
                    ],
                ],
            ],
        ];

        self::updateJoseConfiguration($container, $config, 'key_sets');
    }

    /**
     * @param ContainerBuilder $container
     * @param string           $name
     * @param array            $keyEncryptionAlgorithm
     * @param array            $contentEncryptionAlgorithms
     * @param array            $compressionMethods
     * @param bool             $is_public
     */
    public static function addJWEBuilder(ContainerBuilder $container, string $name, array $keyEncryptionAlgorithm, array $contentEncryptionAlgorithms, array $compressionMethods = ['DEF'], bool $is_public = true)
    {
        $config = [
            self::BUNDLE_ALIAS => [
                'jwe_builders' => [
                    $name => [
                        'is_public' => $is_public,
                        'key_encryption_algorithms' => $keyEncryptionAlgorithm,
                        'content_encryption_algorithms' => $contentEncryptionAlgorithms,
                        'compression_methods' => $compressionMethods,
                    ],
                ],
            ],
        ];

        self::updateJoseConfiguration($container, $config, 'jwe_builders');
    }

    /**
     * @param ContainerBuilder $container
     * @param string           $name
     * @param array            $keyEncryptionAlgorithm
     * @param array            $contentEncryptionAlgorithms
     * @param array            $compressionMethods
     * @param array            $headerCheckers
     * @param array            $serializers
     * @param bool             $is_public
     */
    public static function addJWELoader(ContainerBuilder $container, string $name, array $keyEncryptionAlgorithm, array $contentEncryptionAlgorithms, array $compressionMethods = ['DEF'], array  $headerCheckers = [], array $serializers = ['jwe_compact'], bool $is_public = true)
    {
        $config = [
            self::BUNDLE_ALIAS => [
                'jwe_loaders' => [
                    $name => [
                        'is_public' => $is_public,
                        'key_encryption_algorithms' => $keyEncryptionAlgorithm,
                        'content_encryption_algorithms' => $contentEncryptionAlgorithms,
                        'compression_methods' => $compressionMethods,
                        'header_checkers' => $headerCheckers,
                        'serializers' => $serializers,
                    ],
                ],
            ],
        ];

        self::updateJoseConfiguration($container, $config, 'jwe_loaders');
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     * @param string           $element
     */
    private static function updateJoseConfiguration(ContainerBuilder $container, array $config, string $element)
    {
        $jose_config = current($container->getExtensionConfig(self::BUNDLE_ALIAS));
        if (!isset($jose_config[$element])) {
            $jose_config[$element] = [];
        }
        $jose_config[$element] = array_merge($jose_config[$element], $config[self::BUNDLE_ALIAS][$element]);
        $container->prependExtensionConfig(self::BUNDLE_ALIAS, $jose_config);
    }
}
