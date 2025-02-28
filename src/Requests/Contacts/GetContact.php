<?php

namespace Sensson\Moneybird\Requests\Contacts;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Sensson\Moneybird\Data\Contact;

class GetContact extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $id,
    ) {}

    public function resolveEndpoint(): string
    {
        return "contacts/{$this->id}.json";
    }

    /**
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): Contact
    {
        return new Contact(...$response->json());
    }
}
