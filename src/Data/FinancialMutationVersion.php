<?php

namespace Sensson\Moneybird\Data;

use Spatie\LaravelData\Data;

class FinancialMutationVersion extends Data
{
    public function __construct(
        public ?string $id = null,
        public ?int $version = null,
    ) {
        //
    }
}
