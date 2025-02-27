<?php

namespace Sensson\Moneybird\Data;

use Spatie\LaravelData\Data;

class Event extends Data
{
    public function __construct(
        public string $id = '',
        public ?int $administration_id = null,
        public ?int $user_id = null,
        public string $action = '',
        public ?string $link_entity_id = null,
        public ?string $link_entity_type = null,
        public ?array $data = [],
        public string $created_at = '',
        public string $updated_at = '',
    ) {}
}
