<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Requests\Workflows\ListWorkflows;
use Sensson\Moneybird\Resources\WorkflowResource;

test('workflow resource is instantiated correctly', function () {
    $connector = new MoneybirdConnector;
    $resource = $connector->workflows();

    expect($resource)->toBeInstanceOf(WorkflowResource::class);
});

test('all() calls the list workflows request', function () {
    $mockClient = new MockClient([
        ListWorkflows::class => MockResponse::make([]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);

    (new WorkflowResource($connector))->all();

    $mockClient->assertSent(ListWorkflows::class);
});
