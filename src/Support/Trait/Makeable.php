<?php

declare(strict_types=1);

namespace Support\Trait;

trait Makeable
{
    public static function make(mixed ...$arguments): static
    {
        return new static(...$arguments);
    }
}
