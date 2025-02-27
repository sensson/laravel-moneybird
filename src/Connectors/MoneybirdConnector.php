<?php

namespace Sensson\Moneybird\Connectors;

use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;
use Sensson\Moneybird\Resources\AdministratorResource;
use Sensson\Moneybird\Resources\ContactsResource;

class MoneybirdConnector extends Connector
{
    use AcceptsJson;
    use AlwaysThrowOnErrors;

    public function resolveBaseUrl(): string
    {
        return 'https://moneybird.com/api/v2';
    }

    public function administrations(): AdministratorResource
    {
        return new AdministratorResource($this);
    }

    public function contacts(): ContactsResource
    {
        return new ContactsResource($this);
    }
}
