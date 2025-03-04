<?php

namespace Sensson\Moneybird\Data;

use Sensson\Moneybird\Enums\WebhookEvent;
use Spatie\LaravelData\Data;

class Webhook extends Data
{
    public function __construct(
        public ?string $id = null,
        public ?string $administration_id = null,
        public ?string $url = null,
        /** @var array<WebhookEvent> */
        public array $enabled_events = [],
        public ?bool $last_http_status = null,
        public ?string $last_http_body = null,
        public ?string $token = null,
        public ?string $last_http_response_at = '',
        public ?string $created_at = '',
        public ?string $updated_at = '',
    ) {
        //
    }
}
