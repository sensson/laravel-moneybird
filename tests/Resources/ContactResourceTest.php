<?php

use Illuminate\Support\Collection;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Data\Contact;
use Sensson\Moneybird\Enums\DeliveryMethod;
use Sensson\Moneybird\Requests\Contacts\CreateContact;
use Sensson\Moneybird\Requests\Contacts\GetContact;
use Sensson\Moneybird\Requests\Contacts\ListContacts;
use Sensson\Moneybird\Resources\ContactResource;

test('contacts resource is instantiated correctly', function () {
    $connector = new MoneybirdConnector;
    $resource = $connector->contacts();

    expect($resource)->toBeInstanceOf(ContactResource::class);
});

test('all() calls the list contacts request', function () {
    $mockClient = new MockClient([
        ListContacts::class => MockResponse::make([]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);

    (new ContactResource($connector))->all();

    $mockClient->assertSent(ListContacts::class);
});

test('get() calls the get contact request', function () {
    $mockClient = new MockClient([
        GetContact::class => MockResponse::make([]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);

    (new ContactResource($connector))->get('1234');

    $mockClient->assertSent(GetContact::class);
});

test('create() calls the create contact request', function () {
    $mockClient = new MockClient([
        CreateContact::class => MockResponse::make([]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);

    (new ContactResource($connector))->create(Contact::from([]));

    $mockClient->assertSent(CreateContact::class);
});

it('passes query parameters to all()', function () {
    $mockClient = new MockClient([
        ListContacts::class => MockResponse::make([]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);

    (new ContactResource($connector))->all(
        perPage: 10,
        page: 1,
        query: 'Test Company',
        includeArchived: true,
        todo: 'Follow up'
    );

    $mockClient->assertSent(function (ListContacts $request) {
        $query = $request->query()->all();

        return $query['per_page'] === 10
            && $query['page'] === 1
            && $query['query'] === 'Test Company'
            && $query['include_archived'] === true
            && $query['todo'] === 'Follow up';
    });
});

it('ignores query parameters to all() when they are null', function () {
    $mockClient = new MockClient([
        ListContacts::class => MockResponse::make([]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);

    (new ContactResource($connector))->all(
        perPage: 10,
        includeArchived: false,
    );

    $mockClient->assertSent(function (ListContacts $request) {
        $query = $request->query()->all();

        return $query['per_page'] === 10
            && $query['include_archived'] === false
            && ! isset($query['page'])
            && ! isset($query['query'])
            && ! isset($query['todo']);
    });
});


