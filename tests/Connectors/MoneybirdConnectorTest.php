<?php

use Sensson\Moneybird\Connectors\MoneybirdConnector;

test('connector has correct base url', function () {
    $connector = new MoneybirdConnector;

    expect($connector->resolveBaseUrl())->toBe('https://moneybird.com/api/v2');
});

test('connector accepts json by default', function () {
    $connector = new MoneybirdConnector;

    // Check if the connector uses the AcceptsJson trait
    $traits = class_uses_recursive(get_class($connector));
    expect($traits)->toContain(\Saloon\Traits\Plugins\AcceptsJson::class);
});
