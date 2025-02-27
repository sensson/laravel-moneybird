<?php

namespace Sensson\Moneybird\Resources;

use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Sensson\Moneybird\Requests\Administrations\GetAdministration;
use Sensson\Moneybird\Requests\Administrations\ListAdministrations;

class AdministratorResource extends BaseResource
{
    /**
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function all(): Response
    {
        return $this->connector->send(new ListAdministrations());
    }

    /**
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function get(string $id): Response
    {
        return $this->connector->send(new GetAdministration($id));
    }
}
