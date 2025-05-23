<?php

namespace Sensson\Moneybird\Resources;

use Illuminate\Support\Collection;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Sensson\Moneybird\Data\Administration;
use Sensson\Moneybird\Requests\Administrations\ListAdministrations;

class AdministrationResource extends BaseResource
{
    /**
     * @return Collection<Administration>
     *
     * @throws RequestException|FatalRequestException
     */
    public function all(): Collection
    {
        return collect($this->connector->send(new ListAdministrations)->dtoOrFail());
    }
}
