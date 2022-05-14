<?php

declare(strict_types=1);

namespace Jose\Bundle\JoseFramework\DependencyInjection\Compiler;

use Jose\Bundle\JoseFramework\Serializer\JWESerializer;
use Jose\Bundle\JoseFramework\Serializer\JWSSerializer;
use Jose\Component\Encryption\Serializer\JWESerializerManagerFactory;
use Jose\Component\Signature\Serializer\JWSSerializerManagerFactory;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Serializer\Serializer;

class SymfonySerializerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (! class_exists(Serializer::class)) {
            return;
        }
        if ($container->hasDefinition(JWSSerializerManagerFactory::class)) {
            $container->autowire(JWSSerializer::class, JWSSerializer::class)
                ->setPublic(false)
                ->addTag('serializer.encoder')
                ->addTag('serializer.normalizer')
            ;
        }
        if ($container->hasDefinition(JWESerializerManagerFactory::class)) {
            $container->autowire(JWESerializer::class, JWESerializer::class)
                ->setPublic(false)
                ->addTag('serializer.encoder')
                ->addTag('serializer.normalizer')
            ;
        }
    }
}
