<?php

namespace Sensson\Moneybird\Data;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class SalesInvoice extends Data
{
    public function __construct(
        public ?string $id = null,
        public ?int $administration_id = null,
        public ?string $contact_id = null,
        public ?Contact $contact = null,
        public ?string $contact_person_id = null,
        public ?ContactPerson $contact_person = null,
        public ?string $invoice_id = null,
        public ?string $recurring_sales_invoice_id = null,
        public ?string $subscription_id = null,
        public ?string $workflow_id = null,
        public ?string $document_style_id = null,
        public ?string $identity_id = null,
        public ?int $draft_id = null,
        public ?string $state = null,
        public ?string $invoice_date = null,
        public ?string $due_date = null,
        public ?string $payment_conditions = null,
        public ?string $payment_reference = null,
        public ?string $short_payment_reference = null,
        public ?string $reference = null,
        public ?string $language = null,
        public ?string $currency = null,
        public ?string $discount = null,
        public ?string $original_sales_invoice_id = null,
        public ?bool $paused = null,
        public ?string $paid_at = null,
        public ?string $sent_at = null,
        public ?string $created_at = null,
        public ?string $updated_at = null,
        public ?string $public_view_code = null,
        public ?string $public_view_code_expires_at = null,
        public ?string $version = null,
        #[DataCollectionOf(SalesInvoiceDetail::class)]
        public ?array $details = null,
        public ?array $payments = null,
        public ?string $total_paid = null,
        public ?string $total_unpaid = null,
        public ?string $total_unpaid_base = null,
        public ?bool $prices_are_incl_tax = null,
        public ?string $total_price_excl_tax = null,
        public ?string $total_price_excl_tax_base = null,
        public ?string $total_price_incl_tax = null,
        public ?string $total_price_incl_tax_base = null,
        public ?string $total_discount = null,
        public ?string $marked_dubious_on = null,
        public ?string $marked_uncollectible_on = null,
        public ?int $reminder_count = 0,
        public ?string $next_reminder = null,
        public ?string $original_estimate_id = null,
        public ?string $url = null,
        public ?array $custom_fields = null,
        public ?array $notes = null,
        public ?array $attachments = null,
        #[DataCollectionOf(Event::class)]
        public ?array $events = null,
        public ?array $tax_totals = [],
    ) {}
}
