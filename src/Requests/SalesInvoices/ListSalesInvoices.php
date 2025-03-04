<?php

namespace Sensson\Moneybird\Requests\SalesInvoices;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Sensson\Moneybird\Data\SalesInvoice;

class ListSalesInvoices extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return 'sales_invoices.json';
    }

    /**
     * @return array{mixed: SalesInvoice}
     *
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): array
    {
        return SalesInvoice::collect($response->json());
    }
}
