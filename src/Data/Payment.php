<?php

namespace Sensson\Moneybird\Data;

use Spatie\LaravelData\Data;

class Payment extends Data
{
    public function __construct(
        public ?string $id = null,
        public ?string $administration_id = null,
        public ?string $invoice_type = null,
        public ?string $invoice_id = null,
        public ?string $financial_account_id = null,
        public ?string $user_id = null,
        public ?string $payment_transaction_id = null,
        public ?string $transaction_identifier = null,
        public ?string $price = null,
        public ?string $price_base = null,
        public ?string $payment_date = null,
        public ?string $credit_invoice_id = null,
        public ?string $financial_mutation_id = null,
        public ?string $ledger_account_id = null,
        public ?string $linked_payment_id = null,
        public ?string $manual_payment_action = null,
        public ?string $created_at = null,
        public ?string $updated_at = null,
    ) {
        //
    }
}
