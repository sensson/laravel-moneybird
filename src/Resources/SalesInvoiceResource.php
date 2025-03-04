<?php

namespace Sensson\Moneybird\Resources;

use Illuminate\Support\Collection;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Sensson\Moneybird\Data\SalesInvoice;
use Sensson\Moneybird\Requests\SalesInvoices\CreateSalesInvoice;
use Sensson\Moneybird\Requests\SalesInvoices\DeleteSalesInvoice;
use Sensson\Moneybird\Requests\SalesInvoices\DownloadPdfSalesInvoice;
use Sensson\Moneybird\Requests\SalesInvoices\DownloadUblSalesInvoice;
use Sensson\Moneybird\Requests\SalesInvoices\FindSalesInvoiceByInvoiceId;
use Sensson\Moneybird\Requests\SalesInvoices\GetSalesInvoice;
use Sensson\Moneybird\Requests\SalesInvoices\ListSalesInvoices;
use Sensson\Moneybird\Requests\SalesInvoices\UpdateSalesInvoice;

class SalesInvoiceResource extends BaseResource
{
    /**
     * @return Collection<SalesInvoice>
     *
     * @throws RequestException|FatalRequestException
     */
    public function all(): Collection
    {
        $request = new ListSalesInvoices;

        return collect($this->connector->send($request)->dtoOrFail());
    }

    /**
     * @throws RequestException|FatalRequestException
     */
    public function get(string $id): SalesInvoice
    {
        return $this->connector->send(new GetSalesInvoice($id))->dtoOrFail();
    }

    /**
     * @throws RequestException|FatalRequestException
     */
    public function findByInvoiceId(string $invoiceId): SalesInvoice
    {
        return $this->connector->send(new FindSalesInvoiceByInvoiceId($invoiceId))->dtoOrFail();
    }

    /**
     * @throws RequestException|FatalRequestException
     */
    public function create(SalesInvoice $salesInvoice): SalesInvoice
    {
        $request = new CreateSalesInvoice($salesInvoice);

        return $this->connector->send($request)->dtoOrFail();
    }

    /**
     * @throws RequestException|FatalRequestException
     */
    public function update(string $id, SalesInvoice $salesInvoice): SalesInvoice
    {
        $request = new UpdateSalesInvoice($id, $salesInvoice);

        return $this->connector->send($request)->dtoOrFail();
    }

    /**
     * @throws RequestException|FatalRequestException
     */
    public function delete(string $id): void
    {
        $request = new DeleteSalesInvoice($id);

        $this->connector->send($request);
    }

    /**
     * @throws RequestException|FatalRequestException
     */
    public function downloadPdf(string $id): string
    {
        $request = new DownloadPdfSalesInvoice($id);

        return $this->connector->send($request)->dtoOrFail();
    }

    /**
     * @throws RequestException|FatalRequestException
     */
    public function downloadUbl(string $id): string
    {
        $request = new DownloadUblSalesInvoice($id);

        return $this->connector->send($request)->dtoOrFail();
    }
}
