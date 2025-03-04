<?php

namespace Sensson\Moneybird\Requests\SalesInvoices;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Sensson\Moneybird\Data\SalesInvoice;

class GetSalesInvoice extends Request
{
    protected Method $method = Method::GET;

    public function __construct(protected string $id)
    {
        //
    }

    public function resolveEndpoint(): string
    {
        return "sales_invoices/{$this->id}.json";
    }

    /**
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): SalesInvoice
    {
        return SalesInvoice::from($response->json());
    }
}
