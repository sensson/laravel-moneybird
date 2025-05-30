<?php

namespace Sensson\Moneybird\Resources;

use Illuminate\Support\Collection;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Sensson\Moneybird\Data\Workflow;
use Sensson\Moneybird\Requests\Workflows\ListWorkflows;

class WorkflowResource extends BaseResource
{
    /**
     * @return Collection<Workflow>
     *
     * @throws RequestException|FatalRequestException
     */
    public function all(): Collection
    {
        $request = new ListWorkflows;

        return collect($this->connector->send($request)->dtoOrFail());
    }
}
