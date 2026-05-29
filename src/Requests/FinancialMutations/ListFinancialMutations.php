<?php

namespace Sensson\Moneybird\Requests\FinancialMutations;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Sensson\Moneybird\Data\FinancialMutation;

class ListFinancialMutations extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return 'financial_mutations.json';
    }

    /**
     * @return array{mixed: FinancialMutation}
     *
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): array
    {
        return FinancialMutation::collect($response->json());
    }
}
