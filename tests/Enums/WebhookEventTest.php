<?php

use Sensson\Moneybird\Enums\WebhookEvent;
use Sensson\Moneybird\Enums\WebhookEventGroup;

test('events and event groups can be parsed without throwing', function () {
    expect(WebhookEvent::tryFrom('contact_created'))->toBe(WebhookEvent::ContactCreated)
        ->and(WebhookEvent::tryFrom('future_event'))->toBeNull()
        ->and(WebhookEventGroup::tryFrom('contact'))->toBe(WebhookEventGroup::Contact)
        ->and(WebhookEventGroup::tryFrom('future_group'))->toBeNull();
});

test('all documented event groups are supported', function () {
    $eventGroups = [
        'access_token',
        'administration',
        'administration_automatic_bookers',
        'administration_data_analysis_permission',
        'administration_payments_without_proof',
        'adyen',
        'adyen_banking',
        'adyen_banking_bank_transfer_permission',
        'adyen_payment_instrument',
        'adyen_payment_instrument_network_token',
        'company_assets',
        'company_assets_asset',
        'company_assets_disposal',
        'company_assets_source',
        'company_assets_value_changes',
        'company_assets_value_changes_linear',
        'company_assets_value_changes_arbitrary',
        'company_assets_value_changes_divestment',
        'company_assets_value_changes_full_depreciation',
        'company_assets_value_changes_manual',
        'company_assets_value_change_plan',
        'booking_rule',
        'contact',
        'contact_mandate_request',
        'contact_person',
        'default_identity',
        'default_tax_rate',
        'direct_bank_link',
        'direct_debit',
        'direct_debit_incoming_mandate',
        'direct_debit_transaction',
        'document',
        'document_style',
        'email_domain',
        'estimate',
        'estimate_created_from',
        'estimate_mark',
        'estimate_send',
        'estimate_state_changed',
        'external_sales_invoice',
        'external_sales_invoice_marked_as',
        'external_sales_invoice_state_changed',
        'feature_preference',
        'feed_entry',
        'financial_account',
        'financial_account_bank_link',
        'financial_statement',
        'goal',
        'identity',
        'ledger_account',
        'ledger_account_booking',
        'legal_terms_acceptation',
        'legal_terms_acceptation_email',
        'mobile_app_authentication_factor',
        'mollie_credential',
        'moneybird_banking_transfer',
        'note',
        'order',
        'payment',
        'payment_method',
        'payment_transaction',
        'payment_transaction_batch',
        'personal_iban',
        'ponto',
        'ponto_direct_bank_link',
        'product',
        'project',
        'purchase_transaction',
        'purchase_transaction_batch',
        'recurring_sales_invoice',
        'recurring_sales_invoice_created_from',
        'sales_invoice',
        'sales_invoice_marked_as',
        'sales_invoice_revert',
        'sales_invoice_send',
        'sales_invoice_state_changed',
        'send_payment',
        'smart_transfer',
        'smart_transfer_rule',
        'smart_transfer_trigger',
        'subgoal',
        'subscription',
        'subscription_template',
        'task_lists',
        'task_lists_list',
        'task_lists_list_template',
        'task_lists_task',
        'tax',
        'tax_rate',
        'time_entry',
        'todo',
        'ultimate_benificial_owner',
        'ultimate_beneficial_owner',
        'user',
        'verification',
        'workflow',
    ];

    foreach ($eventGroups as $eventGroup) {
        expect(WebhookEventGroup::tryFrom($eventGroup))
            ->not->toBeNull("Missing webhook event group: {$eventGroup}");
    }
});

test('newly documented events are supported', function () {
    $events = [
        'access_token_created',
        'access_token_revoked',
        'adyen_payment_instrument_network_token_created',
        'adyen_payment_instrument_network_token_updated',
        'adyen_payment_instrument_pin_changed',
        'contact_mandate_destroyed',
        'contact_tax_number_validated',
        'mobile_app_authentication_factor_created',
        'mobile_app_authentication_factor_destroyed',
        'mobile_app_authentication_factor_updated',
        'moneybird_banking_transfer_completed',
        'payment_method_limit_updated',
        'personal_iban_created',
        'personal_iban_destroyed',
        'personal_iban_updated',
        'sales_invoice_created_from_payment_request',
        'task_lists_list_completed',
        'task_lists_list_reopened',
        'task_lists_list_template_published',
        'task_lists_list_template_hidden',
        'task_lists_task_assigned',
        'task_lists_task_unassigned',
        'task_lists_task_name',
        'task_lists_task_report_type_linked',
        'task_lists_task_category_linked',
        'task_lists_task_unlinked',
    ];

    foreach ($events as $event) {
        expect(WebhookEvent::tryFrom($event))
            ->not->toBeNull("Missing webhook event: {$event}");
    }
});
