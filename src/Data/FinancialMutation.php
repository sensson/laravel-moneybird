<?php

namespace Sensson\Moneybird\Data;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class FinancialMutation extends Data
{
    public function __construct(
        public ?string $id = null,
        public ?string $administration_id = null,
        public ?string $amount = null,
        public ?string $code = null,
        public ?string $date = null,
        public ?string $message = null,
        public ?string $contra_account_name = null,
        public ?string $contra_account_number = null,
        public ?string $state = null,
        public ?string $settlement_state = null,
        public ?string $amount_open = null,
        public ?array $sepa_fields = null,
        public ?string $batch_reference = null,
        public ?string $financial_account_id = null,
        public ?string $currency = null,
        public ?string $original_amount = null,
        public ?string $created_at = null,
        public ?string $updated_at = null,
        public ?int $version = null,
        public ?string $financial_statement_id = null,
        public ?string $processed_at = null,
        public ?string $account_servicer_transaction_id = null,
        #[DataCollectionOf(Payment::class)]
        public ?array $payments = null,
        #[DataCollectionOf(LedgerAccountBooking::class)]
        public ?array $ledger_account_bookings = null,
    ) {
        //
    }
}
