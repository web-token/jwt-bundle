<?php

declare(strict_types=1);

namespace Jose\Bundle\JoseFramework\Event;

use Jose\Component\Core\JWKSet;
use Symfony\Contracts\EventDispatcher\Event;
use Throwable;

final class JWELoadingFailureEvent extends Event
{
    public function __construct(
        private string $token,
        private JWKSet $JWKSet,
        private Throwable $throwable
    ) {
    }

    public function getJWKSet(): JWKSet
    {
        return $this->JWKSet;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getThrowable(): Throwable
    {
        return $this->throwable;
    }
}
