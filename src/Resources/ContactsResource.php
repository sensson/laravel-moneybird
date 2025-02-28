<?php

namespace Sensson\Moneybird\Resources;

use Illuminate\Support\Collection;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Sensson\Moneybird\Data\Contact;
use Sensson\Moneybird\Requests\Contacts\GetContact;
use Sensson\Moneybird\Requests\Contacts\ListContacts;

class ContactsResource extends BaseResource
{
    /**
     * @return Collection<Contact>
     *
     * @throws RequestException|FatalRequestException
     */
    public function all(
        ?int $perPage = null,
        ?int $page = null,
        ?string $query = null,
        ?bool $includeArchived = null,
        ?string $todo = null
    ): Collection {
        $request = new ListContacts;

        $query = collect([
            'per_page' => $perPage,
            'page' => $page,
            'query' => $query,
            'include_archived' => $includeArchived,
            'todo' => $todo,
        ])->reject(fn ($value) => $value === null);

        $request->query()->set($query->toArray());

        return collect($this->connector->send($request)->dtoOrFail());
    }

    /**
     * @throws RequestException|FatalRequestException
     */
    public function get(string $id): Contact
    {
        return $this->connector->send(new GetContact($id))->dtoOrFail();
    }
}
