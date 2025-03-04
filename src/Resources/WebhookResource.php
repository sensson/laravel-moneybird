<?php

namespace Sensson\Moneybird\Resources;

use Illuminate\Support\Collection;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Sensson\Moneybird\Data\Webhook;
use Sensson\Moneybird\Requests\Webhooks\CreateWebhook;
use Sensson\Moneybird\Requests\Webhooks\DeleteWebhook;
use Sensson\Moneybird\Requests\Webhooks\ListWebhooks;

class WebhookResource extends BaseResource
{
    /**
     * @return Collection<Webhook>
     *
     * @throws RequestException|FatalRequestException
     */
    public function all(): Collection
    {
        return collect($this->connector->send(new ListWebhooks)->dtoOrFail());
    }

    /**
     * @throws RequestException|FatalRequestException
     */
    public function create(Webhook $webhook): Webhook
    {
        return $this->connector->send(new CreateWebhook($webhook))->dtoOrFail();
    }

    /**
     * @throws RequestException|FatalRequestException
     */
    public function delete(string $id): void
    {
        $this->connector->send(new DeleteWebhook($id));
    }
}
