<?php

namespace Sensson\Moneybird\Casts;

use Saloon\Http\Auth\AccessTokenAuthenticator;

class MoneybirdAuth
{
    /**
     * Cast the given value.
     */
    public function get($model, string $key, $value, array $attributes): ?AccessTokenAuthenticator
    {
        if (is_null($value)) {
            return null;
        }

        return unserialize($value, ['allowed_classes' => true]);
    }

    /**
     * Prepare the given value for storage.
     */
    public function set($model, string $key, $value, array $attributes): mixed
    {
        if (is_null($value)) {
            return null;
        }

        return serialize($value);
    }
}
