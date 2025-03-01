<?php

namespace Sensson\Moneybird\Requests\Ledgers;

use JsonException;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use Sensson\Moneybird\Data\Ledger;

class CreateLedger extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(protected Ledger $ledger, protected string $rgs_code)
    {
        //
    }

    public function resolveEndpoint(): string
    {
        return 'ledger_accounts.json';
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
