<?php

namespace Sensson\Moneybird\Data;

use Spatie\LaravelData\Data;

class LedgerAccountBooking extends Data
{
    public function __construct(
        public ?string $id = null,
        public ?string $administration_id = null,
        public ?string $financial_mutation_id = null,
        public ?string $ledger_account_id = null,
        public ?string $project_id = null,
        public ?string $description = null,
        public ?string $price = null,
        public ?string $created_at = null,
        public ?string $updated_at = null,
    ) {
        //
    }
}
