<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User;

use Webmozart\Assert\Assert;

class Status
{
    private const WAIT = 10;
    private const ACTIVE = 20;

    private int $value;

    public function __construct(int $value)
    {
        Assert::oneOf(
            $value,
            [
                self::WAIT,
                self::ACTIVE,
            ]
        );

        $this->value = $value;
    }

    public static function wait(): self
    {
        return new self(self::WAIT);
    }

    public static function active(): self
    {
        return new self(self::ACTIVE);
    }

    public function isWait(): bool
    {
        return $this->value === self::WAIT;
    }

    public function isActive(): bool
    {
        return $this->value === self::ACTIVE;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
