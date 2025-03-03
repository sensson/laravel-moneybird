<?php

namespace Sensson\Moneybird\Requests\CustomFields;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Sensson\Moneybird\Data\CustomField;

class ListCustomFields extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return 'custom_fields.json';
    }

    /**
     * @return array{mixed: CustomField}
     *
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): array
    {
        return CustomField::collect($response->json());
    }
}
