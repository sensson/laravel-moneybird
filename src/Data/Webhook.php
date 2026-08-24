<?php

namespace Sensson\Moneybird\Data;

use Sensson\Moneybird\Casts\WebhookEventSubscriptionCast;
use Sensson\Moneybird\Enums\WebhookEvent;
use Sensson\Moneybird\Enums\WebhookEventGroup;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;

class Webhook extends Data
{
    public function __construct(
        public ?string $id = null,
        public ?string $administration_id = null,
        public ?string $url = null,
        /** @var array<WebhookEvent|WebhookEventGroup|string> */
        #[WithCast(WebhookEventSubscriptionCast::class)]
        public array $enabled_events = [],
        public ?bool $last_http_status = null,
        public ?string $last_http_body = null,
        public ?string $token = null,
        public ?string $secret = null,
        public ?string $last_http_response_at = '',
        public ?string $created_at = '',
        public ?string $updated_at = '',
    ) {
        //
    }
}
