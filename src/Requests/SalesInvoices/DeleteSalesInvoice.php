<?php

namespace Sensson\Moneybird\Requests\SalesInvoices;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteSalesInvoice extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(protected string $id)
    {
        //
    }

    public function resolveEndpoint(): string
    {
        return "sales_invoices/{$this->id}.json";
    }
}
