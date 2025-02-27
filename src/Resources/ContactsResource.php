<?php

namespace Sensson\Moneybird\Resources;

use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Sensson\Moneybird\Requests\Contacts\GetContact;
use Sensson\Moneybird\Requests\Contacts\ListContacts;

class ContactsResource extends BaseResource
{
    /**
     * Get all contacts
     *
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function all(): Response
    {
        return $this->connector->send(new ListContacts());
    }

    /**
     * Get a single contact by ID
     *
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function get(string $id): Response
    {
        return $this->connector->send(new GetContact($id));
    }
}