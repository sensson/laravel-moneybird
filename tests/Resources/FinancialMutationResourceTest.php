<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Data\Booking;
use Sensson\Moneybird\Data\FinancialMutation;
use Sensson\Moneybird\Data\LedgerAccountBooking;
use Sensson\Moneybird\Data\Payment;
use Sensson\Moneybird\Requests\FinancialMutations\GetFinancialMutation;
use Sensson\Moneybird\Requests\FinancialMutations\GetFinancialMutationsByIds;
use Sensson\Moneybird\Requests\FinancialMutations\LinkBookingFinancialMutation;
use Sensson\Moneybird\Requests\FinancialMutations\ListFinancialMutations;
use Sensson\Moneybird\Requests\FinancialMutations\SynchronizeFinancialMutations;
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

it('passes pagination and filter parameters to all()', function () {
    $mockClient = new MockClient([
        ListFinancialMutations::class => MockResponse::make([]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);

    (new FinancialMutationResource($connector))->all(perPage: 10, page: 2, filter: 'period:this_month');

    $mockClient->assertSent(function (ListFinancialMutations $request) {
        $query = $request->query()->all();

        return $query['per_page'] === 10
            && $query['page'] === 2
            && $query['filter'] === 'period:this_month';
    });
});

test('synchronization() calls the synchronize request', function () {
    $mockClient = new MockClient([
        SynchronizeFinancialMutations::class => MockResponse::make([
            ['id' => '123456', 'version' => 3],
            ['id' => '654321', 'version' => 1],
        ]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);

    $versions = (new FinancialMutationResource($connector))->synchronization('period:this_month');

    $mockClient->assertSent(function (SynchronizeFinancialMutations $request) {
        return $request->query()->all()['filter'] === 'period:this_month';
    });

    expect($versions)->toHaveCount(2)
        ->and($versions->first()->id)->toBe('123456')
        ->and($versions->first()->version)->toBe(3);
});

test('getByIds() calls the synchronization batch request', function () {
    $mockClient = new MockClient([
        GetFinancialMutationsByIds::class => MockResponse::make([
            ['id' => '123456', 'amount' => '100.00'],
        ]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);

    $mutations = (new FinancialMutationResource($connector))->getByIds(['123456', '654321']);

    $mockClient->assertSent(function (GetFinancialMutationsByIds $request) {
        return $request->body()->all()['ids'] === ['123456', '654321'];
    });

    expect($mutations)->toHaveCount(1)
        ->and($mutations->first()->id)->toBe('123456');
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

it('omits a null booking id from the unlink booking body', function () {
    $mockClient = new MockClient([
        UnlinkBookingFinancialMutation::class => MockResponse::make([], 200),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);

    $booking = Booking::from(['booking_type' => 'Payment']);

    (new FinancialMutationResource($connector))->unlinkBooking('123456', $booking);

    $mockClient->assertSent(function (UnlinkBookingFinancialMutation $request) {
        return ! array_key_exists('booking_id', $request->body()->all());
    });
});

test('synchronization() works without a filter', function () {
    $mockClient = new MockClient([
        SynchronizeFinancialMutations::class => MockResponse::make([]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);

    (new FinancialMutationResource($connector))->synchronization();

    $mockClient->assertSent(function (SynchronizeFinancialMutations $request) {
        return $request->query()->all() === [];
    });
});

test('linkBooking() returns a financial mutation', function () {
    $mockClient = new MockClient([
        LinkBookingFinancialMutation::class => MockResponse::make([
            'id' => '123456',
            'state' => 'processed',
        ]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);

    $booking = Booking::from(['booking_type' => 'LedgerAccount', 'booking_id' => '654321']);

    $mutation = (new FinancialMutationResource($connector))->linkBooking('123456', $booking);

    expect($mutation)->toBeInstanceOf(FinancialMutation::class)
        ->and($mutation->id)->toBe('123456')
        ->and($mutation->state)->toBe('processed');
});

test('get() hydrates nested payments and ledger account bookings', function () {
    $mockClient = new MockClient([
        GetFinancialMutation::class => MockResponse::make([
            'id' => '123456',
            'amount' => '100.00',
            'payments' => [
                ['id' => 'p1', 'invoice_type' => 'SalesInvoice', 'invoice_id' => 'inv1'],
            ],
            'ledger_account_bookings' => [
                ['id' => 'b1', 'ledger_account_id' => 'la1', 'price' => '100.00'],
            ],
        ]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);

    $mutation = (new FinancialMutationResource($connector))->get('123456');

    expect($mutation->payments[0])->toBeInstanceOf(Payment::class)
        ->and($mutation->payments[0]->invoice_id)->toBe('inv1')
        ->and($mutation->ledger_account_bookings[0])->toBeInstanceOf(LedgerAccountBooking::class)
        ->and($mutation->ledger_account_bookings[0]->ledger_account_id)->toBe('la1');
});
