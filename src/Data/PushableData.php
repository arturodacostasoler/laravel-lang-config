<?php

declare(strict_types=1);

namespace LaravelLang\Config\Data;

use BackedEnum;
use LaravelLang\Config\Concerns\HasValues;

class PushableData
{
    use HasValues;

    public function __construct(
        protected readonly string $key,
        protected readonly ?string $default = null
    ) {}

    public function all(): array
    {
        return config($this->key, config($this->default));
    }

    public function push(mixed $value): static
    {
        config()->push($this->key, $value);

        return $this;
    }

    public function set(BackedEnum|int|string $key, mixed $value): mixed
    {
        config()->set($key = $this->key . '.' . $this->resolveKey($key), $value);

        return $this->get($key);
    }
}