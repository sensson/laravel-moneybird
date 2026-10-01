<?php

namespace Sensson\Moneybird\Requests\Contacts;

use JsonException;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use Sensson\Moneybird\Data\MoneybirdPaymentsMandateUrl;

class CreateMoneybirdPaymentsMandateUrl extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(protected string $contactId)
    {
        //
    }

    public function resolveEndpoint(): string
    {
        return "contacts/{$this->contactId}/moneybird_payments_mandate/url.json";
    }

    protected function defaultBody(): array
    {
        return [
            'mandate_request' => (object) [],
        ];
    }

    /**
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): MoneybirdPaymentsMandateUrl
    {
        return MoneybirdPaymentsMandateUrl::from($response->json());
    }
}
