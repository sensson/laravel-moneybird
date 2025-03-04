<?php

namespace Sensson\Moneybird\Requests\SalesInvoices;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class DownloadUblSalesInvoice extends Request
{
    protected Method $method = Method::GET;

    public function __construct(protected string $id)
    {
        //
    }

    public function resolveEndpoint(): string
    {
        return "sales_invoices/{$this->id}/download_ubl";
    }

    public function createDtoFromResponse(Response $response): string
    {
        return $response->body();
    }
}
