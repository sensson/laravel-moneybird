<?php

namespace Sensson\Moneybird\Requests\Ledgers;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteLedger extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(protected string $id)
    {
        //
    }

    public function resolveEndpoint(): string
    {
        return "ledger_accounts/{$this->id}.json";
    }
}
