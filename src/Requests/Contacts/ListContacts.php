<?php

namespace Sensson\Moneybird\Requests\Contacts;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Sensson\Moneybird\Data\Contact;

class ListContacts extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return 'contacts.json';
    }

    /**
     * @return array{mixed: Contact}
     *
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): array
    {
        return Contact::collect($response->json());
    }
}
