<?php

namespace Sensson\Moneybird\Requests\FinancialMutations;

use JsonException;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use Sensson\Moneybird\Data\Booking;
use Sensson\Moneybird\Data\FinancialMutation;

class LinkBookingFinancialMutation extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function __construct(
        protected string $id,
        protected Booking $booking,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "financial_mutations/{$this->id}/link_booking.json";
    }

    protected function defaultBody(): array
    {
        return collect($this->booking->toArray())
            ->reject(fn (mixed $value): bool => $value === null)
            ->toArray();
    }

    /**
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): FinancialMutation
    {
        return FinancialMutation::from($response->json());
    }
}
