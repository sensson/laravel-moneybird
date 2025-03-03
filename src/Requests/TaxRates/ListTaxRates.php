<?php

namespace Sensson\Moneybird\Requests\TaxRates;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Sensson\Moneybird\Data\TaxRate;

class ListTaxRates extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return 'tax_rates.json';
    }

    /**
     * @return array{mixed: TaxRate}
     *
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): array
    {
        return TaxRate::collect($response->json());
    }
}
