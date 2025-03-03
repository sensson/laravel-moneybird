<?php

namespace Sensson\Moneybird\Data;

use Sensson\Moneybird\Enums\Source;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Data;

class CustomField extends Data
{
    public function __construct(
        public ?string $id = null,
        public ?string $administration_id = null,
        public string $name = '',
        #[WithCast(EnumCast::class, type: Source::class)]
        public Source $source = Source::Contact,
    ) {
        //
    }
}
