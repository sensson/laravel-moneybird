<?php

namespace Sensson\Moneybird\Requests\FinancialMutations;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Sensson\Moneybird\Data\FinancialMutation;

class GetFinancialMutation extends Request
{
    protected Method $method = Method::GET;

    public function __construct(protected string $id)
    {
        //
    }

    public function resolveEndpoint(): string
    {
        return "financial_mutations/{$this->id}.json";
    }

    /**
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): FinancialMutation
    {
        return FinancialMutation::from($response->json());
    }
}
