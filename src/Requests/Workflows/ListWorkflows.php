<?php

namespace Sensson\Moneybird\Requests\Workflows;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Sensson\Moneybird\Data\Workflow;

class ListWorkflows extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return 'workflows.json';
    }

    /**
     * @return array{mixed: Workflow}
     *
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): array
    {
        return Workflow::collect($response->json());
    }
}
