<?php

namespace Sensson\Moneybird\Enums;

enum TaxRateType: string
{
    case All = 'all';
    case GeneralJournalDocument = 'general_journal_document';
    case PurchaseInvoice = 'purchase_invoice';
    case SalesInvoice = 'sales_invoice';
}
