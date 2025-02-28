<?php

namespace Sensson\Moneybird\Data;

use Spatie\LaravelData\Data;

class ContactPerson extends Data
{
    public function __construct(
        public string $id = '',
        public string $administration_id = '',
        public string $contact_id = '',
        public ?string $firstname = null,
        public ?string $lastname = null,
        public ?string $phone = null,
        public ?string $email = null,
        public ?string $department = null,
        public string $version = '',
        public string $created_at = '',
        public string $updated_at = '',
    ) {}
}
