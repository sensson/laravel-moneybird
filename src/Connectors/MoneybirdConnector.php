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
use Sensson\Moneybird\Resources\AdministrationResource;
use Sensson\Moneybird\Resources\ContactResource;
use Sensson\Moneybird\Resources\CustomFieldResource;
use Sensson\Moneybird\Resources\LedgerResource;
use Sensson\Moneybird\Resources\SalesInvoiceResource;
use Sensson\Moneybird\Resources\TaxRateResource;

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

    public function administrations(): AdministrationResource
    {
        return new AdministrationResource($this);
    }

    public function contacts(): ContactResource
    {
        return new ContactResource($this);
    }

    public function ledgers(): LedgerResource
    {
        return new LedgerResource($this);
    }

    public function taxRates(): TaxRateResource
    {
        return new TaxRateResource($this);
    }

    public function customFields(): CustomFieldResource
    {
        return new CustomFieldResource($this);
    }

    public function salesInvoices(): SalesInvoiceResource
    {
        return new SalesInvoiceResource($this);
    }
}
