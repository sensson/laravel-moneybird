<?php

namespace Sensson\Moneybird\Data;

use Spatie\LaravelData\Data;

class CustomFieldAttribute extends Data
{
    public function __construct(
        public int $id,
        public string $value,
    )
    {
        //
    }
}
