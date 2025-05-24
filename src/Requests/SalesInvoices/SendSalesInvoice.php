<?php

namespace Sensson\Moneybird\Requests\SalesInvoices;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use Sensson\Moneybird\Data\SalesInvoice;
use Sensson\Moneybird\Enums\DeliveryMethod;

class SendSalesInvoice extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function __construct(
        protected string $id,
        protected ?DeliveryMethod $deliveryMethod = null
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "sales_invoices/{$this->id}/send_invoice.json";
    }

    protected function defaultBody(): array
    {
        $body = [];

        if ($this->deliveryMethod !== null) {
            $body['delivery_method'] = $this->deliveryMethod->value;
        }

        return $body;
    }

    /**
     * @throws \JsonException
     */
    public function createDtoFromResponse(Response $response): SalesInvoice
    {
        return SalesInvoice::from($response->json());
    }
}
