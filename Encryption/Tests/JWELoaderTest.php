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

namespace Jose\Bundle\Encryption\Tests;

use Jose\Component\Encryption\JWEDecrypter;
use Jose\Component\Encryption\JWEDecrypterFactory;
use Jose\Component\Encryption\Serializer\JWESerializerManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @group Bundle
 * @group Functional
 */
final class JWEDecrypterTest extends WebTestCase
{
    public function testJWEDecrypterFactoryIsAvailable()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        self::assertNotNull($container);
        self::assertTrue($container->has(JWEDecrypterFactory::class));
    }

    public function testJWEDecrypterFactoryCanCreateAJWEDecrypter()
    {
        $client = static::createClient();

        /** @var JWEDecrypterFactory $jweFactory */
        $jweFactory = $client->getContainer()->get(JWEDecrypterFactory::class);

        $jwe = $jweFactory->create(['RSA1_5'], ['A256GCM'], ['DEF'], []);

        self::assertInstanceOf(JWEDecrypter::class, $jwe);
    }

    public function testJWEDecrypterFromConfigurationIsAvailable()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        self::assertTrue($container->has('jose.jwe_decrypter.loader1'));

        $jwe = $container->get('jose.jwe_decrypter.loader1');
        self::assertInstanceOf(JWEDecrypter::class, $jwe);
    }

    public function testJWEDecrypterFromExternalBundleExtensionIsAvailable()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        self::assertTrue($container->has('jose.jwe_decrypter.loader2'));

        $jwe = $container->get('jose.jwe_decrypter.loader2');
        self::assertInstanceOf(JWEDecrypter::class, $jwe);
    }

    public function testJWESerializerManagerFromConfigurationIsAvailable()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        self::assertTrue($container->has('jose.jwe_serializer.jwe_serializer1'));

        $jwe = $container->get('jose.jwe_serializer.jwe_serializer1');
        self::assertInstanceOf(JWESerializerManager::class, $jwe);
    }

    public function testJWESerializerManagerFromExternalBundleExtensionIsAvailable()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        self::assertTrue($container->has('jose.jwe_serializer.jwe_serializer2'));

        $jwe = $container->get('jose.jwe_serializer.jwe_serializer2');
        self::assertInstanceOf(JWESerializerManager::class, $jwe);
    }
}
