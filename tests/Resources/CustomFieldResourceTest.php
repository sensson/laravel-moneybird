<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Requests\CustomFields\ListCustomFields;
use Sensson\Moneybird\Resources\CustomFieldResource;

test('custom field resource is instantiated correctly', function () {
    $connector = new MoneybirdConnector;
    $resource = $connector->customFields();

    expect($resource)->toBeInstanceOf(CustomFieldResource::class);
});

test('all() calls the list custom fields request', function () {
    $mockClient = new MockClient([
        ListCustomFields::class => MockResponse::make([]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);

    (new CustomFieldResource($connector))->all();

    $mockClient->assertSent(ListCustomFields::class);
});
