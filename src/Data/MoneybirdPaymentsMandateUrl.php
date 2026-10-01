<?php

namespace Sensson\Moneybird\Data;

use Spatie\LaravelData\Data;

class MoneybirdPaymentsMandateUrl extends Data
{
    public function __construct(
        public string $url,
    ) {
        //
    }
}
