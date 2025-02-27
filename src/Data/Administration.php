<?php

namespace Sensson\Moneybird\Data;

use Spatie\LaravelData\Data;

class Administration extends Data
{
    public function __construct(
        public string $id = '',
        public string $name = '',
        public string $language = '',
        public string $currency = '',
        public string $country = '',
        public string $time_zone = '',
        public bool $access = false,
    ) {}
}
