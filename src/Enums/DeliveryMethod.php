<?php

namespace Sensson\Moneybird\Enums;

enum DeliveryMethod: string
{
    case Email = 'Email';
    case Simplerinvoicing = 'Simplerinvoicing';
    case Peppol = 'Peppol';
    case Manual = 'Manual';
}
