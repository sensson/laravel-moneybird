<?php

namespace Sensson\Moneybird\Requests\Webhooks;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Sensson\Moneybird\Data\Webhook;

class ListWebhooks extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return 'webhooks.json';
    }

    /**
     * @return array{mixed: Webhook}
     *
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): array
    {
        return Webhook::collect($response->json());
    }
}
