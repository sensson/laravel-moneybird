<?php

namespace Sensson\Moneybird\Resources;

use Illuminate\Support\Collection;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Sensson\Moneybird\Data\CustomField;
use Sensson\Moneybird\Requests\CustomFields\ListCustomFields;

class CustomFieldResource extends BaseResource
{
    /**
     * @return Collection<CustomField>
     *
     * @throws RequestException|FatalRequestException
     */
    public function all(): Collection
    {
        $request = new ListCustomFields;

        return collect($this->connector->send($request)->dtoOrFail());
    }
}
