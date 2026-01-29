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
        $salesInvoice = [
            ...$this->salesInvoice->toArray(),
            'details_attributes' => collect($this->salesInvoice->details)->toArray(),
            'custom_fields_attributes' => collect($this->salesInvoice->custom_fields)->toArray(),
        ];

        return ['sales_invoice' => $salesInvoice];
    }

    /**
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): SalesInvoice
    {
        return SalesInvoice::from($response->json());
    }
}
