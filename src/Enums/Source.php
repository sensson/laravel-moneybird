<?php

namespace Sensson\Moneybird\Enums;

enum Source: string
{
    case Contact = 'contact';
    case SalesInvoice = 'sales_invoice';
    case Estimate = 'estimate';
    case Identity = 'identity';
}
