<?php

namespace Sensson\Moneybird\Requests\Webhooks;

use JsonException;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use Sensson\Moneybird\Data\Webhook;

class CreateWebhook extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(protected Webhook $webhook)
    {
        //
    }

    public function resolveEndpoint(): string
    {
        return 'webhooks.json';
    }

    protected function defaultBody(): array
    {
        return [
            'webhook' => [
                'url' => $this->webhook->url,
                'enabled_events' => $this->webhook->enabled_events,
            ],
        ];
    }

    /**
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): Webhook
    {
        return Webhook::from($response->json());
    }
}
