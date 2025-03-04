<?php

namespace Sensson\Moneybird\Requests\Webhooks;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteWebhook extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(protected string $id)
    {
        //
    }

    public function resolveEndpoint(): string
    {
        return "webhooks/{$this->id}.json";
    }
}
