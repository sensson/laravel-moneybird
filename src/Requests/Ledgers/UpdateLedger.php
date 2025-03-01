<?php

namespace Sensson\Moneybird\Requests\Ledgers;

use JsonException;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use Sensson\Moneybird\Data\Ledger;

class UpdateLedger extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function __construct(protected string $id, protected Ledger $ledger, protected string $rgs_code)
    {
        //
    }

    public function resolveEndpoint(): string
    {
        return "ledger_accounts/{$this->id}.json";
    }

    protected function defaultBody(): array
    {
        $ledgerAccount = $this->ledger
            ->only('name', 'account_type', 'account_id', 'parent_id', 'allowed_document_types', 'description')
            ->toArray();

        return [
            'ledger_account' => $ledgerAccount,
            'rgs_code' => $this->rgs_code,
        ];
    }

    /**
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): Ledger
    {
        return Ledger::from($response->json());
    }
}