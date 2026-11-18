<?php

use Sensson\Moneybird\Data\SalesInvoice;

test('a sales invoice reports its state', function (string $state, string $method) {
    expect(SalesInvoice::from(['state' => $state])->{$method}())->toBeTrue();
})->with([
    'draft' => ['draft', 'isDraft'],
    'scheduled' => ['scheduled', 'isScheduled'],
    'open' => ['open', 'isOpen'],
    'pending payment' => ['pending_payment', 'isPendingPayment'],
    'reminded' => ['reminded', 'isReminded'],
    'late' => ['late', 'isLate'],
    'paid' => ['paid', 'isPaid'],
    'uncollectible' => ['uncollectible', 'isUncollectible'],
]);

test('a sent sales invoice is not a draft', function () {
    expect(SalesInvoice::from(['state' => 'open'])->isDraft())->toBeFalse();
});
