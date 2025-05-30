<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Data\Workflow;
use Sensson\Moneybird\Enums\WorkflowType;
use Sensson\Moneybird\Requests\Workflows\ListWorkflows;

test('list workflows request has correct endpoint', function () {
    expect((new ListWorkflows)->resolveEndpoint())->toBe('workflows.json');
});

test('list workflows request uses GET method', function () {
    expect((new ListWorkflows)->getMethod())->toBe(Method::GET);
});

test('list workflows request returns data collection of workflows', function () {
    $mockData = [
        [
            'id' => '123456',
            'administration_id' => 654321,
            'type' => 'InvoiceWorkflow',
            'name' => 'Standard Invoice Workflow',
            'default' => true,
            'currency' => 'EUR',
            'language' => 'nl',
            'active' => true,
            'prices_are_incl_tax' => false,
            'created_at' => '2023-01-01T12:00:00.000Z',
            'updated_at' => '2023-01-01T12:00:00.000Z',
        ],
        [
            'id' => '789012',
            'administration_id' => 654321,
            'type' => 'EstimateWorkflow',
            'name' => 'Standard Estimate Workflow',
            'default' => false,
            'currency' => 'EUR',
            'language' => 'en',
            'active' => true,
            'prices_are_incl_tax' => true,
            'created_at' => '2023-01-01T12:00:00.000Z',
            'updated_at' => '2023-01-01T12:00:00.000Z',
        ],
    ];

    $mockClient = new MockClient([
        ListWorkflows::class => MockResponse::make($mockData, 200),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $response = $connector->send(new ListWorkflows);
    $mockClient->assertSent(ListWorkflows::class);

    $collection = collect($response->dto());

    expect($collection)->toHaveCount(2)
        ->and($collection->first())->toBeInstanceOf(Workflow::class)
        ->and($collection->first()->id)->toBe('123456')
        ->and($collection->first()->administration_id)->toBe(654321)
        ->and($collection->first()->type)->toBe(WorkflowType::Invoice)
        ->and($collection->first()->name)->toBe('Standard Invoice Workflow')
        ->and($collection->first()->default)->toBeTrue()
        ->and($collection->first()->currency)->toBe('EUR')
        ->and($collection->first()->language)->toBe('nl')
        ->and($collection->first()->active)->toBeTrue()
        ->and($collection->first()->prices_are_incl_tax)->toBeFalse()
        ->and($collection->last())->toBeInstanceOf(Workflow::class)
        ->and($collection->last()->id)->toBe('789012')
        ->and($collection->last()->type)->toBe(WorkflowType::Estimate)
        ->and($collection->last()->name)->toBe('Standard Estimate Workflow')
        ->and($collection->last()->default)->toBeFalse()
        ->and($collection->last()->prices_are_incl_tax)->toBeTrue();
});

test('list workflows request handles workflow type enum values correctly', function () {
    $mockData = [
        [
            'id' => '123456',
            'administration_id' => 654321,
            'type' => WorkflowType::Invoice->value,
            'name' => 'Invoice Workflow',
            'default' => true,
            'currency' => 'EUR',
            'language' => 'nl',
            'active' => true,
            'prices_are_incl_tax' => false,
            'created_at' => '2023-01-01T12:00:00.000Z',
            'updated_at' => '2023-01-01T12:00:00.000Z',
        ],
        [
            'id' => '789012',
            'administration_id' => 654321,
            'type' => WorkflowType::Estimate->value,
            'name' => 'Estimate Workflow',
            'default' => false,
            'currency' => 'EUR',
            'language' => 'en',
            'active' => true,
            'prices_are_incl_tax' => true,
            'created_at' => '2023-01-01T12:00:00.000Z',
            'updated_at' => '2023-01-01T12:00:00.000Z',
        ],
    ];

    $mockClient = new MockClient([
        ListWorkflows::class => MockResponse::make($mockData, 200),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $response = $connector->send(new ListWorkflows);
    $mockClient->assertSent(ListWorkflows::class);

    $collection = collect($response->dto());

    expect($collection)->toHaveCount(2)
        ->and($collection->first()->type)->toBe(WorkflowType::Invoice)
        ->and($collection->last()->type)->toBe(WorkflowType::Estimate)
        ->and($collection->first()->type->value)->toBe('InvoiceWorkflow')
        ->and($collection->last()->type->value)->toBe('EstimateWorkflow');
});
