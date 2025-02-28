<?php

namespace Sensson\Moneybird\Requests\Administrations;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Sensson\Moneybird\Data\Administration;

class GetAdministration extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $id,
    ) {}

    public function resolveEndpoint(): string
    {
        return "administrations/{$this->id}.json";
    }

    /**
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): Administration
    {
        return Administration::from($response->json());
    }
}
