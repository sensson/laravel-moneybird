<?php

namespace Sensson\Moneybird\Requests\Ledgers;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Sensson\Moneybird\Data\Ledger;

class GetLedger extends Request
{
    protected Method $method = Method::GET;

    public function __construct(protected string $id)
    {
        //
    }

    public function resolveEndpoint(): string
    {
        return "ledger_accounts/{$this->id}.json";
    }

    /**
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): Ledger
    {
        return Ledger::from($response->json());
    }
}
