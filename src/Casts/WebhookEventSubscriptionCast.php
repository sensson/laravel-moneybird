<?php

namespace Sensson\Moneybird\Casts;

use BackedEnum;
use Sensson\Moneybird\Enums\WebhookEvent;
use Sensson\Moneybird\Enums\WebhookEventGroup;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Casts\Uncastable;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;

class WebhookEventSubscriptionCast implements Cast
{
    /**
     * @return array<WebhookEvent|WebhookEventGroup|string>|Uncastable
     */
    public function cast(
        DataProperty $property,
        mixed $value,
        array $properties,
        CreationContext $context
    ): array|Uncastable {
        if (! is_array($value)) {
            return Uncastable::create();
        }

        foreach ($value as $key => $subscription) {
            if ($subscription instanceof WebhookEvent || $subscription instanceof WebhookEventGroup) {
                continue;
            }

            if ($subscription instanceof BackedEnum) {
                $subscription = $subscription->value;
            }

            if (! is_string($subscription)) {
                continue;
            }

            $value[$key] = WebhookEvent::tryFrom($subscription)
                ?? WebhookEventGroup::tryFrom($subscription)
                ?? $subscription;
        }

        return $value;
    }
}
