<?php

namespace Sensson\Moneybird\Connectors;

use Saloon\Http\Connector;
use Saloon\Http\Response;
use Saloon\RateLimitPlugin\Contracts\RateLimitStore;
use Saloon\RateLimitPlugin\Limit;
use Saloon\RateLimitPlugin\Stores\MemoryStore;
use Saloon\RateLimitPlugin\Traits\HasRateLimits;
use Saloon\Traits\Conditionable;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;
use Sensson\Moneybird\Exceptions\AccessTokenRevokedException;
use Throwable;
use Sensson\Moneybird\Resources\AdministrationResource;
use Sensson\Moneybird\Resources\ContactResource;
use Sensson\Moneybird\Resources\CustomFieldResource;
use Sensson\Moneybird\Resources\LedgerResource;
use Sensson\Moneybird\Resources\SalesInvoiceResource;
use Sensson\Moneybird\Resources\TaxRateResource;
use Sensson\Moneybird\Resources\WebhookResource;
use Sensson\Moneybird\Resources\WorkflowResource;

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

    public function getRequestException(Response $response, ?Throwable $senderException): ?Throwable
    {
        if ($response->status() === 401 && str_contains($response->body(), 'access token revoked')) {
            return new AccessTokenRevokedException($response, previous: $senderException);
        }

        return null;
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

    public function webhooks(): WebhookResource
    {
        return new WebhookResource($this);
    }

    public function workflows(): WorkflowResource
    {
        return new WorkflowResource($this);
    }
}
