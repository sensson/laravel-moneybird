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
        public ?string $attention = null,
        public ?string $email = null,
        public ?string $email_ubl = null,
        public bool $send_invoices_to_attention = false,
        public bool $send_invoices_to_email = false,
        public bool $send_estimates_to_attention = false,
        public bool $send_estimates_to_email = false,
        public ?string $sepa_active = null,
        public ?string $sepa_iban = null,
        public ?string $sepa_iban_account_name = null,
        public ?string $sepa_bic = null,
        public ?string $sepa_mandate_id = null,
        public ?string $sepa_mandate_date = null,
        public ?string $sepa_sequence_type = null,
        public ?string $si_identifier = null,
        public ?string $si_identifier_type = null,
        public array $custom_fields = [],
        public bool $direct_debit = false,
        public string $created_at = '',
        public string $updated_at = '',
        public array $notes = [],
        #[DataCollectionOf(ContactPerson::class)]
        public array $contact_people = [],
        #[DataCollectionOf(Event::class)]
        public array $events = [],
    ) {}
}
