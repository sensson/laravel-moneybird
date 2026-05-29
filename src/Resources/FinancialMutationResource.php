<?php

namespace Sensson\Moneybird\Resources;

use Illuminate\Support\Collection;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Sensson\Moneybird\Data\Booking;
use Sensson\Moneybird\Data\FinancialMutation;
use Sensson\Moneybird\Requests\FinancialMutations\GetFinancialMutation;
use Sensson\Moneybird\Requests\FinancialMutations\LinkBookingFinancialMutation;
use Sensson\Moneybird\Requests\FinancialMutations\ListFinancialMutations;
use Sensson\Moneybird\Requests\FinancialMutations\UnlinkBookingFinancialMutation;

class FinancialMutationResource extends BaseResource
{
    /**
     * @return Collection<FinancialMutation>
     *
     * @throws RequestException|FatalRequestException
     */
    public function all(?int $perPage = null, ?int $page = null): Collection
    {
        $request = new ListFinancialMutations;

        $query = collect([
            'per_page' => $perPage,
            'page' => $page,
        ])->reject(fn (mixed $value): bool => $value === null);

        $request->query()->set($query->toArray());

        return collect($this->connector->send($request)->dtoOrFail());
    }

    /**
     * @throws RequestException|FatalRequestException
     */
    public function get(string $id): FinancialMutation
    {
        return $this->connector->send(new GetFinancialMutation($id))->dtoOrFail();
    }

    /**
     * @throws RequestException|FatalRequestException
     */
    public function linkBooking(string $id, Booking $booking): FinancialMutation
    {
        $request = new LinkBookingFinancialMutation($id, $booking);

        return $this->connector->send($request)->dtoOrFail();
    }

    /**
     * @throws RequestException|FatalRequestException
     */
    public function unlinkBooking(string $id, Booking $booking): void
    {
        $request = new UnlinkBookingFinancialMutation($id, $booking);

        $this->connector->send($request);
    }
}
