<?php

namespace Sensson\Moneybird\Resources;

use Illuminate\Support\Collection;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Sensson\Moneybird\Data\TaxRate;
use Sensson\Moneybird\Requests\TaxRates\ListTaxRates;

class TaxRateResource extends BaseResource
{
    /**
     * @return Collection<TaxRate>
     *
     * @throws RequestException|FatalRequestException
     */
    public function all(
        ?int $perPage = null,
        ?int $page = null,
        ?string $filter = null,
    ): Collection {
        $request = new ListTaxRates;

        $query = collect([
            'per_page' => $perPage,
            'page' => $page,
            'filter' => $filter,
        ])->reject(fn ($value) => $value === null);

        $request->query()->set($query->toArray());

        return collect($this->connector->send($request)->dtoOrFail());
    }
}
