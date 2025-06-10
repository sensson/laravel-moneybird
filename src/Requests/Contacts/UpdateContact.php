<?php

namespace Sensson\Moneybird\Requests\Contacts;

use JsonException;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use Sensson\Moneybird\Data\Contact;

class UpdateContact extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function __construct(protected string $id, protected Contact $contact)
    {
        //
    }

    public function resolveEndpoint(): string
    {
        return "contacts/{$this->id}.json";
    }

    protected function defaultBody(): array
    {
        return [
            'contact' => $this->contact->toArray(),
        ];
    }

    /**
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): Contact
    {
        return Contact::from($response->json());
    }
}
