<?php

namespace Sensson\Moneybird\Requests\Administrations;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Sensson\Moneybird\Data\Administration;

class ListAdministrations extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return 'administrations.json';
    }

    /**
     * @return array{mixed: Administration}
     *
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): array
    {
        return Administration::collect($response->json());
    }
}
