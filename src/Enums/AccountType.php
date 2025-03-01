<?php

namespace Sensson\Moneybird\Enums;

enum AccountType: string
{
    case NonCurrentAssets = 'non_current_assets';
    case CurrentAssets = 'current_assets';
    case Equity = 'equity';
    case Provisions = 'provisions';
    case NonCurrentLiabilities = 'non_current_liabilities';
    case CurrentLiabilities = 'current_liabilities';
    case Revenue = 'revenue';
    case DirectCosts = 'direct_costs';
    case Expenses = 'expenses';
    case OtherIncomeExpenses = 'other_income_expenses';
}
