<?php

declare(strict_types=1);

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2019 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace Jose\Bundle\JoseFramework\Event;

use Symfony\Component\EventDispatcher\Event;

final class JWSBuiltFailureEvent extends Event
{
    /**
     * @var \Throwable
     */
    private $throwable;

    /**
     * @var string|null
     */
    protected $payload;

    /**
     * @var bool
     */
    protected $isPayloadDetached;

    /**
     * @var array
     */
    protected $signatures = [];

    /**
     * @var bool|null
     */
    protected $isPayloadEncoded = null;

    public function __construct(?string $payload, array $signatures, ?bool $isPayloadDetached, ?bool $isPayloadEncoded, \Throwable $throwable)
    {
        $this->throwable = $throwable;
        $this->payload = $payload;
        $this->signatures = $signatures;
        $this->isPayloadDetached = $isPayloadDetached;
        $this->isPayloadEncoded = $isPayloadEncoded;
    }

    public function getPayload(): ?string
    {
        return $this->payload;
    }

    public function isPayloadDetached(): bool
    {
        return $this->isPayloadDetached;
    }

    public function getSignatures(): array
    {
        return $this->signatures;
    }

    public function getisPayloadEncoded(): ?bool
    {
        return $this->isPayloadEncoded;
    }

    public function getThrowable(): \Throwable
    {
        return $this->throwable;
    }
}
