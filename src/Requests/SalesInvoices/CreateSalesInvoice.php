<?php

namespace Sensson\Moneybird\Requests\SalesInvoices;

use JsonException;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use Sensson\Moneybird\Data\SalesInvoice;

class CreateSalesInvoice extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(protected SalesInvoice $salesInvoice)
    {
        //
    }

    public function resolveEndpoint(): string
    {
        return 'sales_invoices.json';
    }

    protected function defaultBody(): array
    {
        return ['sales_invoice' => $this->salesInvoice->toArray()];
    }

    /**
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): SalesInvoice
    {
        return SalesInvoice::from($response->json());
    }
}
