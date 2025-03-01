<?php

namespace Sensson\Moneybird\Data;

use Exception;
use Sensson\Moneybird\Enums\AccountType;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Data;

class Ledger extends Data
{
    /**
     * @throws Exception
     */
    public function __construct(
        public string $name,
        #[WithCast(EnumCast::class, type: AccountType::class)]
        public AccountType $account_type,
        public string $id = '',
        public string $administration_id = '',
        public ?string $parent_id = null,
        public array $allowed_document_types = [],
        public ?array $taxonomy_item = [],
        public ?string $financial_account_id = null,
        public string $created_at = '',
        public string $updated_at = '',
    ) {
        $this->guardAgainstInvalidDocumentTypes();
    }

    /**
     * @throws Exception
     */
    public function guardAgainstInvalidDocumentTypes(): void
    {
        $allowedDocumentTypes = [
            'sales_invoice',
            'purchase_invoice',
            'general_journal_document',
            'financial_mutation',
            'payment',
        ];

        $invalidDocumentTypes = collect($this->allowed_document_types)
            ->filter(function ($type) use ($allowedDocumentTypes) {
                return ! in_array($type, $allowedDocumentTypes);
            })
            ->values()
            ->all();

        if (! empty($invalidDocumentTypes)) {
            throw new Exception('Invalid document types: '.implode(', ', $invalidDocumentTypes));
        }
    }
}
