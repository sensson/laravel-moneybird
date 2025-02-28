<?php

namespace Sensson\Moneybird\Data;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class Contact extends Data
{
    public function __construct(
        public string $id = '',
        public string $administration_id = '',
        public ?string $company_name = null,
        public ?string $firstname = null,
        public ?string $lastname = null,
        public ?string $address1 = null,
        public ?string $address2 = null,
        public ?string $zipcode = null,
        public ?string $city = null,
        public ?string $country = null,
        public ?string $phone = null,
        public string $delivery_method = '',
        public ?string $customer_id = null,
        public ?string $tax_number = null,
        public ?string $chamber_of_commerce = null,
        public ?string $bank_account = null,
        public bool $is_trusted = false,
        public ?float $max_transfer_amount = null,
        public ?string $attention = null,
        public ?string $email = null,
        public bool $email_ubl = false,
        public ?string $send_invoices_to_attention = null,
        public ?string $send_invoices_to_email = null,
        public ?string $send_estimates_to_attention = null,
        public ?string $send_estimates_to_email = null,
        public bool $sepa_active = false,
        public ?string $sepa_iban = null,
        public ?string $sepa_iban_account_name = null,
        public ?string $sepa_bic = null,
        public ?string $sepa_mandate_id = null,
        public ?string $sepa_mandate_date = null,
        public ?string $sepa_sequence_type = null,
        public ?string $credit_card_number = null,
        public ?string $credit_card_reference = null,
        public ?string $credit_card_type = null,
        public ?string $tax_number_validated_at = null,
        public ?bool $tax_number_valid = null,
        public ?string $invoice_workflow_id = null,
        public ?string $estimate_workflow_id = null,
        public ?string $si_identifier = null,
        public ?string $si_identifier_type = null,
        public bool $moneybird_payments_mandate = false,
        public array $custom_fields = [],
        public bool $direct_debit = false,
        public string $created_at = '',
        public string $updated_at = '',
        public ?int $version = null,
        public ?string $sales_invoices_url = null,
        public array $notes = [],
        public bool $archived = false,
        #[DataCollectionOf(ContactPerson::class)]
        public array $contact_people = [],
        #[DataCollectionOf(Event::class)]
        public array $events = [],
    ) {}
}
