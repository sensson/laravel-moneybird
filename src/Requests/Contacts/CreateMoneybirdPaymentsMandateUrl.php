<?php

namespace Sensson\Moneybird\Requests\Contacts;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Sensson\Moneybird\Data\MoneybirdPaymentsMandateUrl;

class CreateMoneybirdPaymentsMandateUrl extends Request
{
    protected Method $method = Method::POST;

    public function __construct(protected string $contactId)
    {
        //
    }

    public function resolveEndpoint(): string
    {
        return "contacts/{$this->contactId}/moneybird_payments_mandate/url.json";
    }

    /**
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): MoneybirdPaymentsMandateUrl
    {
        return MoneybirdPaymentsMandateUrl::from($response->json());
    }
}
