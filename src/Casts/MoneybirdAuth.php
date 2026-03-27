<?php

namespace Sensson\Moneybird\Casts;

use DateTimeImmutable;
use Saloon\Http\Auth\AccessTokenAuthenticator;

class MoneybirdAuth
{
    public function get($model, string $key, $value, array $attributes): ?AccessTokenAuthenticator
    {
        if (is_null($value)) {
            return null;
        }

        $data = json_decode($value, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $legacy = unserialize($value, [
                'allowed_classes' => [AccessTokenAuthenticator::class, DateTimeImmutable::class],
            ]);

            return new AccessTokenAuthenticator(
                accessToken: $legacy->getAccessToken(),
                refreshToken: $legacy->getRefreshToken(),
                expiresAt: $legacy->getExpiresAt(),
            );
        }

        return new AccessTokenAuthenticator(
            accessToken: $data['access_token'],
            refreshToken: $data['refresh_token'] ?? null,
            expiresAt: isset($data['expires_at']) ? new DateTimeImmutable($data['expires_at']) : null,
        );
    }

    public function set($model, string $key, $value, array $attributes): mixed
    {
        if (is_null($value)) {
            return null;
        }

        return json_encode([
            'access_token' => $value->getAccessToken(),
            'refresh_token' => $value->getRefreshToken(),
            'expires_at' => $value->getExpiresAt()?->format(DateTimeImmutable::ATOM),
        ]);
    }
}
