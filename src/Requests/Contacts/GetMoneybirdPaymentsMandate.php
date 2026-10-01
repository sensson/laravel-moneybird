<?php

namespace Sensson\Moneybird\Requests\Contacts;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Sensson\Moneybird\Data\MoneybirdPaymentsMandate;

class GetMoneybirdPaymentsMandate extends Request
{
    protected Method $method = Method::GET;

    public function __construct(protected string $contactId)
    {
        //
    }

    public function resolveEndpoint(): string
    {
        return "contacts/{$this->contactId}/moneybird_payments_mandate.json";
    }

    /**
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): MoneybirdPaymentsMandate
    {
        return MoneybirdPaymentsMandate::from($response->json());
    }
}
