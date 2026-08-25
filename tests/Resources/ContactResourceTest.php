<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Data\Contact;
use Sensson\Moneybird\Requests\Contacts\CreateContact;
use Sensson\Moneybird\Requests\Contacts\CreateMoneybirdPaymentsMandateUrl;
use Sensson\Moneybird\Requests\Contacts\DeleteMoneybirdPaymentsMandate;
use Sensson\Moneybird\Requests\Contacts\GetContact;
use Sensson\Moneybird\Requests\Contacts\GetMoneybirdPaymentsMandate;
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

test('create moneybird payments mandate url calls the create mandate url request', function () {
    $mockClient = new MockClient([
        CreateMoneybirdPaymentsMandateUrl::class => MockResponse::make([
            'url' => 'https://moneybird.com/mandate/setup/abc123',
            'expires_at' => '2026-08-25T12:00:00Z',
        ]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);

    (new ContactResource($connector))->createMoneybirdPaymentsMandateUrl('1234');

    $mockClient->assertSent(CreateMoneybirdPaymentsMandateUrl::class);
});

test('get moneybird payments mandate calls the get mandate request', function () {
    $mockClient = new MockClient([
        GetMoneybirdPaymentsMandate::class => MockResponse::make([]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);

    (new ContactResource($connector))->getMoneybirdPaymentsMandate('1234');

    $mockClient->assertSent(GetMoneybirdPaymentsMandate::class);
});

test('delete moneybird payments mandate calls the delete mandate request', function () {
    $mockClient = new MockClient([
        DeleteMoneybirdPaymentsMandate::class => MockResponse::make(status: 204),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);

    (new ContactResource($connector))->deleteMoneybirdPaymentsMandate('1234');

    $mockClient->assertSent(DeleteMoneybirdPaymentsMandate::class);
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
