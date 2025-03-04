<?php

namespace Sensson\Moneybird\Requests\SalesInvoices;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Sensson\Moneybird\Data\SalesInvoice;

class FindSalesInvoiceByInvoiceId extends Request
{
    protected Method $method = Method::GET;

    public function __construct(protected string $invoiceId)
    {
        //
    }

    public function resolveEndpoint(): string
    {
        return "sales_invoices/find_by_invoice_id/{$this->invoiceId}.json";
    }

    /**
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): SalesInvoice
    {
        return SalesInvoice::from($response->json());
    }
}
