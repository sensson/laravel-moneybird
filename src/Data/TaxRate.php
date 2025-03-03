<?php

namespace Sensson\Moneybird\Data;

use Sensson\Moneybird\Enums\TaxRateType;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Data;

class TaxRate extends Data
{
    public function __construct(
        public string $name,
        public string $partial_name,
        public string $percentage,
        #[WithCast(EnumCast::class, type: TaxRateType::class)]
        public TaxRateType $tax_rate_type = TaxRateType::All,
        public string $country = '',
        public ?bool $show_tax = null,
        public bool $active = true,
        public string $created_after = '',
        public string $updated_after = '',
    ) {
        //
    }
}
