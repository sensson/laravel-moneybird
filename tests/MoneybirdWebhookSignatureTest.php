<?php

use Carbon\CarbonImmutable;
use Sensson\Moneybird\MoneybirdWebhookSignature;

$now = CarbonImmutable::createFromTimestamp(1_748_534_400);
$payload = '{"event":"sales_invoice_created"}';
$secret = 'whsec_test_secret';

function signatureHeader(int $timestamp, string $payload, string $secret): string
{
    $signature = hash_hmac('sha256', $timestamp.'.'.$payload, $secret);

    return "t={$timestamp},v1={$signature}";
}

it('accepts a valid signature', function () use ($now, $payload, $secret) {
    $header = signatureHeader($now->getTimestamp(), $payload, $secret);

    expect(MoneybirdWebhookSignature::isValid($payload, $header, $secret, timestamp: $now))->toBeTrue();
});

it('rejects an invalid signature', function () use ($now, $payload, $secret) {
    $header = "t={$now->getTimestamp()},v1=".str_repeat('0', 64);

    expect(MoneybirdWebhookSignature::isValid($payload, $header, $secret, timestamp: $now))->toBeFalse();
});

it('rejects a stale timestamp', function () use ($now, $payload, $secret) {
    $timestamp = $now->getTimestamp() - 301;

    expect(MoneybirdWebhookSignature::isValid(
        $payload,
        signatureHeader($timestamp, $payload, $secret),
        $secret,
        timestamp: $now,
    ))->toBeFalse();
});

it('rejects a timestamp too far in the future', function () use ($now, $payload, $secret) {
    $timestamp = $now->getTimestamp() + 301;

    expect(MoneybirdWebhookSignature::isValid(
        $payload,
        signatureHeader($timestamp, $payload, $secret),
        $secret,
        timestamp: $now,
    ))->toBeFalse();
});

it('accepts multiple v1 signatures when one matches', function () use ($now, $payload, $secret) {
    $signature = hash_hmac('sha256', $now->getTimestamp().'.'.$payload, $secret);
    $header = "t={$now->getTimestamp()},v1=".str_repeat('0', 64).",v1={$signature}";

    expect(MoneybirdWebhookSignature::isValid($payload, $header, $secret, timestamp: $now))->toBeTrue();
});

it('rejects a missing timestamp', function () use ($now, $payload, $secret) {
    $signature = hash_hmac('sha256', $now->getTimestamp().'.'.$payload, $secret);

    expect(MoneybirdWebhookSignature::isValid($payload, "v1={$signature}", $secret, timestamp: $now))->toBeFalse();
});

it('rejects a missing v1 signature', function () use ($now, $payload, $secret) {
    expect(MoneybirdWebhookSignature::isValid(
        $payload,
        "t={$now->getTimestamp()}",
        $secret,
        timestamp: $now,
    ))->toBeFalse();
});

it('rejects a malformed timestamp', function () use ($now, $payload, $secret) {
    expect(MoneybirdWebhookSignature::isValid(
        $payload,
        't=not-a-timestamp,v1='.str_repeat('0', 64),
        $secret,
        timestamp: $now,
    ))->toBeFalse();
});

it('ignores unknown signature prefixes', function () use ($now, $payload, $secret) {
    $signature = hash_hmac('sha256', $now->getTimestamp().'.'.$payload, $secret);
    $header = "v2=unrecognised,t={$now->getTimestamp()},future=value,v1={$signature}";

    expect(MoneybirdWebhookSignature::isValid($payload, $header, $secret, timestamp: $now))->toBeTrue();
});

it('requires the exact raw request body', function () use ($now, $secret) {
    $rawPayload = "{\n  \"event\": \"sales_invoice_created\"\n}";
    $reserializedPayload = '{"event":"sales_invoice_created"}';
    $header = signatureHeader($now->getTimestamp(), $rawPayload, $secret);

    expect(MoneybirdWebhookSignature::isValid(
        $reserializedPayload,
        $header,
        $secret,
        timestamp: $now,
    ))->toBeFalse();
});
