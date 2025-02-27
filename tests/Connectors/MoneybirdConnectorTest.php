<?php

use Sensson\Moneybird\Connectors\MoneybirdConnector;

test('connector has correct base url', function () {
    $connector = new MoneybirdConnector;

    expect($connector->resolveBaseUrl())->toBe('https://moneybird.com/api/v2');
});

test('connector base url includes administration id when set', function () {
    $administrationId = '123456';
    $connector = new MoneybirdConnector;
    $connector->administration($administrationId);

    expect($connector->resolveBaseUrl())->toBe("https://moneybird.com/api/v2/{$administrationId}");
});

test('connector for administration method returns self for chaining', function () {
    $connector = new MoneybirdConnector;

    expect($connector->administration('123456'))->toBe($connector);
});

test('connector accepts json by default', function () {
    $connector = new MoneybirdConnector;

    // Check if the connector uses the AcceptsJson trait
    $traits = class_uses_recursive(get_class($connector));
    expect($traits)->toContain(\Saloon\Traits\Plugins\AcceptsJson::class);
});
