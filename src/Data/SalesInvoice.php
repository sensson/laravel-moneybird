<?php

namespace Sensson\Moneybird\Data;

use Sensson\Moneybird\Enums\DeliveryMethod;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class SalesInvoice extends Data
{
    public function __construct(
        public ?string $id = null,
        public ?string $administration_id = null,
        public ?string $contact_id = null,
        public ?string $contact_person_id = null,
        public ?Contact $contact = null,
        public ?ContactPerson $contact_person = null,
        public ?string $invoice_id = null,
        public ?string $invoice_sequence_id = null,
        public ?string $workflow_id = null,
        public ?string $document_style_id = null,
        public ?string $identity_id = null,
        public ?string $draft_id = null,
        public ?string $state = null,
        public ?string $invoice_date = null,
        public ?string $due_date = null,
        public ?int $first_due_interval = null,
        public ?string $payment_reference = null,
        public ?string $reference = null,
        public ?string $language = null,
        public ?string $currency = null,
        public ?string $discount = null,
        public ?string $original_sales_invoice_id = null,
        public ?bool $paused = null,
        public ?string $paid_at = null,
        public ?string $sent_at = null,
        public ?DeliveryMethod $delivery_method = null,
        public ?string $created_at = null,
        public ?string $updated_at = null,
        #[DataCollectionOf(SalesInvoiceDetail::class)]
        public ?array $details = null,
        public ?array $payments = null,
        public ?array $notes = null,
        public ?array $attachments = null,
        #[DataCollectionOf(Event::class)]
        public ?array $events = null,
        public ?string $version = null,
        public ?bool $prices_are_incl_tax = null,
        public ?string $source = null,
        public ?string $source_url = null,
        public ?string $total_price_excl_tax = null,
        public ?string $total_price_incl_tax = null,
        public ?string $total_tax = null,
        public ?string $tax_number = null,
        public ?string $total_unpaid = null,
        public ?string $total_unpaid_base = null,
        public ?string $url = null,
        public ?array $custom_fields = null,
        public ?bool $seen_by_recipient = null,
        #[DataCollectionOf(SalesInvoiceDetail::class)]
        public ?array $details_attributes = null,
    ) {}
}
