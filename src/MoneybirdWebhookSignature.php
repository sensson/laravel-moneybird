<?php

namespace Sensson\Moneybird;

use Carbon\CarbonImmutable;

class MoneybirdWebhookSignature
{
    public static function isValid(
        string $payload,
        string $header,
        string $secret,
        int $tolerance = 300,
        ?CarbonImmutable $timestamp = null,
    ): bool {
        if ($tolerance < 0) {
            return false;
        }

        $timestamps = [];
        $signatures = [];

        foreach (explode(',', $header) as $part) {
            [$scheme, $value] = array_pad(explode('=', trim($part), 2), 2, null);

            if ($value === null) {
                continue;
            }

            if ($scheme === 't') {
                $timestamps[] = trim($value);
            }

            if ($scheme === 'v1') {
                $signatures[] = trim($value);
            }
        }

        if (count($timestamps) !== 1 || $signatures === []) {
            return false;
        }

        $deliveryTimestamp = filter_var($timestamps[0], FILTER_VALIDATE_INT);

        if ($deliveryTimestamp === false) {
            return false;
        }

        $now = ($timestamp ?? CarbonImmutable::now())->getTimestamp();

        if (abs((float) $now - $deliveryTimestamp) > $tolerance) {
            return false;
        }

        $expected = hash_hmac('sha256', $deliveryTimestamp.'.'.$payload, $secret);

        foreach ($signatures as $signature) {
            if (hash_equals($expected, $signature)) {
                return true;
            }
        }

        return false;
    }
}
