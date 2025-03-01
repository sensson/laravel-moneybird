<?php

namespace Sensson\Moneybird\Resources;

use Illuminate\Support\Collection;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Sensson\Moneybird\Data\Ledger;
use Sensson\Moneybird\Requests\Ledgers\ListLedgers;

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
}
