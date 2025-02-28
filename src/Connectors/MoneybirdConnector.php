<?php

namespace Sensson\Moneybird\Connectors;

use Saloon\Http\Connector;
use Saloon\RateLimitPlugin\Contracts\RateLimitStore;
use Saloon\RateLimitPlugin\Limit;
use Saloon\RateLimitPlugin\Stores\MemoryStore;
use Saloon\RateLimitPlugin\Traits\HasRateLimits;
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
    use HasRateLimits;

    protected ?string $administrationId = null;

    public function resolveBaseUrl(): string
    {
        $baseUrl = 'https://moneybird.com/api/v2';

        if ($this->administrationId) {
            return "{$baseUrl}/{$this->administrationId}";
        }

        return $baseUrl;
    }

    protected function resolveLimits(): array
    {
        return [
            Limit::allow(150)->everyFiveMinutes(),
        ];
    }

    protected function resolveRateLimitStore(): RateLimitStore
    {
        return new MemoryStore;
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
