<?php

namespace Sensson\Moneybird\Resources;

use Illuminate\Support\Collection;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Sensson\Moneybird\Data\Ledger;
use Sensson\Moneybird\Requests\Ledgers\CreateLedger;
use Sensson\Moneybird\Requests\Ledgers\DeleteLedger;
use Sensson\Moneybird\Requests\Ledgers\ListLedgers;
use Sensson\Moneybird\Requests\Ledgers\UpdateLedger;

class LedgerResource extends BaseResource
{
    /**
     * @return Collection<Ledger>
     *
     * @throws RequestException|FatalRequestException
     */
    public function all(): Collection
    {
        $request = new ListLedgers;

        return collect($this->connector->send($request)->dtoOrFail());
    }

    /**
     * @throws RequestException|FatalRequestException
     */
    public function create(Ledger $ledger, string $rgs_code): Ledger
    {
        $request = new CreateLedger($ledger, $rgs_code);

        return $this->connector->send($request)->dtoOrFail();
    }

    /**
     * @throws RequestException|FatalRequestException
     */
    public function update(string $id, Ledger $ledger, string $rgs_code): Ledger
    {
        $request = new UpdateLedger($id, $ledger, $rgs_code);

        return $this->connector->send($request)->dtoOrFail();
    }

    /**
     * @throws RequestException|FatalRequestException
     */
    public function delete(string $id): void
    {
        $request = new DeleteLedger($id);

        $this->connector->send($request);
    }
}
