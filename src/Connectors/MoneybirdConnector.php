<?php

namespace Sensson\Moneybird\Connectors;

use Saloon\Http\Connector;
use Saloon\Traits\Conditionable;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;
use Sensson\Moneybird\Resources\AdministratorResource;
use Sensson\Moneybird\Resources\ContactsResource;

class MoneybirdConnector extends Connector
{
    use AcceptsJson;
    use AlwaysThrowOnErrors;
    use Conditionable;

    protected ?string $administrationId = null;

    public function resolveBaseUrl(): string
    {
        $baseUrl = 'https://moneybird.com/api/v2';

        if ($this->administrationId) {
            return "{$baseUrl}/{$this->administrationId}";
        }

        return $baseUrl;
    }

    public function administration(string $administrationId): self
    {
        $this->administrationId = $administrationId;

        return $this;
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
