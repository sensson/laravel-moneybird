<?php

namespace Sensson\Moneybird\Requests\Contacts;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteMoneybirdPaymentsMandate extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(protected string $contactId)
    {
        //
    }

    public function resolveEndpoint(): string
    {
        return "contacts/{$this->contactId}/moneybird_payments_mandate.json";
    }
}
