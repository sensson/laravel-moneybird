<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Data\CustomField;
use Sensson\Moneybird\Enums\Source;
use Sensson\Moneybird\Requests\CustomFields\ListCustomFields;

test('list custom fields request has correct endpoint', function () {
    expect((new ListCustomFields)->resolveEndpoint())->toBe('custom_fields.json');
});

test('list custom fields request uses GET method', function () {
    expect((new ListCustomFields)->getMethod())->toBe(Method::GET);
});

test('list custom fields request returns data collection of custom fields', function () {
    $mockData = [
        [
            'id' => '123456',
            'administration_id' => '654321',
            'name' => 'Customer ID',
            'source' => 'contact',
        ],
    ];

    $mockClient = new MockClient([
        ListCustomFields::class => MockResponse::make($mockData, 200),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $response = $connector->send(new ListCustomFields);

    $collection = collect($response->dto());

    expect($collection->first())->toBeInstanceOf(CustomField::class)
        ->and($collection->first()->source)->toBe(Source::Contact);
});
