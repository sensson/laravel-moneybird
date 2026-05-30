<?php

namespace Sensson\Moneybird\Data;

use Spatie\LaravelData\Data;

class Booking extends Data
{
    public function __construct(
        public string $booking_type,
        public ?string $booking_id = null,
        public ?string $price_base = null,
        public ?string $price = null,
        public ?string $description = null,
        public ?string $payment_batch_identifier = null,
        public ?string $project_id = null,
        public bool|string|null $mark_open_sepa_transaction_as_paid = null,
    ) {
        //
    }
}
