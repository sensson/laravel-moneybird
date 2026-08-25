<?php

namespace Sensson\Moneybird\Data;

use Spatie\LaravelData\Data;

class MoneybirdPaymentsMandate extends Data
{
    public function __construct(
        public ?string $type = null,
        public bool $sepa_mandate = false,
        public ?string $bank = null,
        public ?string $iban = null,
        public ?string $bic = null,
        public ?string $iban_account_name = null,
        public ?string $card_expiry_month = null,
        public ?string $card_expiry_year = null,
        public ?string $card_final_digits = null,
        public ?string $created_at = null,
    ) {
        //
    }
}
