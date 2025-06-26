<?php

namespace Sensson\Moneybird\Data;

use Spatie\LaravelData\Data;

class SalesInvoiceDetail extends Data
{
    public function __construct(
        public ?string $id = null,
        public ?string $administration_id = null,
        public ?string $tax_rate_id = null,
        public ?string $ledger_account_id = null,
        public ?string $product_id = null,
        public ?string $project_id = null,
        public ?string $amount = null,
        public ?string $amount_decimal = null,
        public ?string $description = null,
        public ?string $price = null,
        public ?string $period = null,
        public ?string $row_order = null,
        public ?string $total_price_excl_tax_with_discount = null,
        public ?string $total_price_excl_tax_with_discount_base = null,
        public ?array $tax_report_reference = [],
        public ?string $mandatory_tax_text = null,
        public ?string $created_at = null,
        public ?string $updated_at = null,
    ) {}
}
