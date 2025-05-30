<?php

namespace Sensson\Moneybird\Enums;

enum WorkflowType: string
{
    case Invoice = 'InvoiceWorkFlow';
    case Estimate = 'EstimateWorkflow';
}
