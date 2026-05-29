<?php

namespace Sensson\Moneybird\Requests\FinancialMutations;

use JsonException;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use Sensson\Moneybird\Data\FinancialMutation;

class GetFinancialMutationsByIds extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  array<int, string>  $ids
     */
    public function __construct(protected array $ids)
    {
        //
    }

    public function resolveEndpoint(): string
    {
        return 'financial_mutations/synchronization.json';
    }

    protected function defaultBody(): array
    {
        return [
            'ids' => $this->ids,
        ];
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
