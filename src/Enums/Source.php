<?php

namespace Sensson\Moneybird\Enums;

enum Source: string
{
    case Contact = 'contact';
    case SalesInvoices = 'sales_invoices';
    case Identity = 'identity';
}
