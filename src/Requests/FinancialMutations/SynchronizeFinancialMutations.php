<?php

namespace Sensson\Moneybird\Requests\FinancialMutations;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Sensson\Moneybird\Data\FinancialMutationVersion;

class SynchronizeFinancialMutations extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return 'financial_mutations/synchronization.json';
    }

    /**
     * @return array{mixed: FinancialMutationVersion}
     *
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): array
    {
        return FinancialMutationVersion::collect($response->json());
    }
}
