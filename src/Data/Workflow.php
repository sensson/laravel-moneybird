<?php

namespace Sensson\Moneybird\Data;

use Sensson\Moneybird\Enums\WorkflowType;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Data;

class Workflow extends Data
{
    public function __construct(
        public ?string $id = null,
        public ?int $administration_id = null,
        #[WithCast(EnumCast::class, type: WorkflowType::class)]
        public ?WorkflowType $type = null,
        public ?string $name = null,
        public ?bool $default = null,
        public ?string $currency = null,
        public ?string $language = null,
        public ?bool $active = null,
        public ?bool $prices_are_incl_tax = null,
        public ?string $created_at = null,
        public ?string $updated_at = null,
    ) {}
}
