<?php

namespace Sensson\Moneybird\Requests\Ledgers;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Sensson\Moneybird\Data\Ledger;

class ListLedgers extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return 'ledger_accounts.json';
    }

    /**
     * @return array{mixed: Ledger}
     *
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): array
    {
        return Ledger::collect($response->json());
    }
}
