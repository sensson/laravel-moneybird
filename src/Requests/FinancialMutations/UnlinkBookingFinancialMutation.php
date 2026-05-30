<?php

namespace Sensson\Moneybird\Requests\FinancialMutations;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Sensson\Moneybird\Data\Booking;

class UnlinkBookingFinancialMutation extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::DELETE;

    public function __construct(
        protected string $id,
        protected Booking $booking,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return "financial_mutations/{$this->id}/unlink_booking.json";
    }

    protected function defaultBody(): array
    {
        return collect([
            'booking_type' => $this->booking->booking_type,
            'booking_id' => $this->booking->booking_id,
        ])->reject(fn (mixed $value): bool => $value === null)->toArray();
    }
}
