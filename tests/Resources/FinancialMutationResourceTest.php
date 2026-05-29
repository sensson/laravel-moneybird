<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Data\Booking;
use Sensson\Moneybird\Requests\FinancialMutations\GetFinancialMutation;
use Sensson\Moneybird\Requests\FinancialMutations\LinkBookingFinancialMutation;
use Sensson\Moneybird\Requests\FinancialMutations\ListFinancialMutations;
use Sensson\Moneybird\Requests\FinancialMutations\UnlinkBookingFinancialMutation;
use Sensson\Moneybird\Resources\FinancialMutationResource;

test('financial mutation resource is instantiated correctly', function () {
    $connector = new MoneybirdConnector;
    $resource = $connector->financialMutations();

    expect($resource)->toBeInstanceOf(FinancialMutationResource::class);
});

test('all() calls the list financial mutations request', function () {
    $mockClient = new MockClient([
        ListFinancialMutations::class => MockResponse::make([]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);

    (new FinancialMutationResource($connector))->all();

    $mockClient->assertSent(ListFinancialMutations::class);
});

it('passes pagination parameters to all()', function () {
    $mockClient = new MockClient([
        ListFinancialMutations::class => MockResponse::make([]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);

    (new FinancialMutationResource($connector))->all(perPage: 10, page: 2);

    $mockClient->assertSent(function (ListFinancialMutations $request) {
        $query = $request->query()->all();

        return $query['per_page'] === 10 && $query['page'] === 2;
    });
});

test('get() calls the get financial mutation request', function () {
    $mockClient = new MockClient([
        GetFinancialMutation::class => MockResponse::make([
            'id' => '123456',
            'amount' => '100.00',
            'state' => 'unprocessed',
        ]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);

    (new FinancialMutationResource($connector))->get('123456');

    $mockClient->assertSent(GetFinancialMutation::class);
});

test('linkBooking() calls the link booking request', function () {
    $mockClient = new MockClient([
        LinkBookingFinancialMutation::class => MockResponse::make([
            'id' => '123456',
            'state' => 'processed',
        ]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);

    $booking = Booking::from([
        'booking_type' => 'LedgerAccount',
        'booking_id' => '654321',
        'price' => '100.00',
    ]);

    (new FinancialMutationResource($connector))->linkBooking('123456', $booking);

    $mockClient->assertSent(function (LinkBookingFinancialMutation $request) {
        $body = $request->body()->all();

        return $body['booking_type'] === 'LedgerAccount'
            && $body['booking_id'] === '654321'
            && $body['price'] === '100.00';
    });
});

it('rejects null parameters from the link booking body', function () {
    $mockClient = new MockClient([
        LinkBookingFinancialMutation::class => MockResponse::make(['id' => '123456']),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);

    $booking = Booking::from([
        'booking_type' => 'Payment',
        'booking_id' => '654321',
    ]);

    (new FinancialMutationResource($connector))->linkBooking('123456', $booking);

    $mockClient->assertSent(function (LinkBookingFinancialMutation $request) {
        return ! array_key_exists('price', $request->body()->all())
            && ! array_key_exists('description', $request->body()->all());
    });
});

test('unlinkBooking() calls the unlink booking request', function () {
    $mockClient = new MockClient([
        UnlinkBookingFinancialMutation::class => MockResponse::make([], 200),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);

    $booking = Booking::from([
        'booking_type' => 'Payment',
        'booking_id' => '654321',
    ]);

    (new FinancialMutationResource($connector))->unlinkBooking('123456', $booking);

    $mockClient->assertSent(function (UnlinkBookingFinancialMutation $request) {
        $body = $request->body()->all();

        return $body['booking_type'] === 'Payment' && $body['booking_id'] === '654321';
    });
});
