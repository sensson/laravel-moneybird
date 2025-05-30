<?php

namespace Sensson\Moneybird\Enums;

enum WorkflowType: string
{
    case Invoice = 'InvoiceWorkflow';
    case Estimate = 'EstimateWorkflow';
}
