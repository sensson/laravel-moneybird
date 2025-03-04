<?php

namespace Sensson\Moneybird\Enums;

/**
 * This is a list of all possible webhook events in Moneybird. Feel free
 * to use this in your own app or package.
 */
enum WebhookEvent: string
{
    case AdministrationActivated = 'administration_activated';
    case AdministrationAdded = 'administration_added';
    case AdministrationAdyenOffboardingPerformedByAdmin = 'administration_adyen_offboarding_performed_by_admin';
    case AdministrationCancelled = 'administration_cancelled';
    case AdministrationChanged = 'administration_changed';
    case AdministrationDeleted = 'administration_deleted';
    case AdministrationReactivated = 'administration_reactivated';
    case AdministrationRemoved = 'administration_removed';
    case AdministrationSuspended = 'administration_suspended';
    case AdministrationAutomaticBookersActivated = 'administration_automatic_bookers_activated';
    case AdministrationAutomaticBookersDeactivated = 'administration_automatic_bookers_deactivated';
    case AdministrationDataAnalysisPermissionUnset = 'administration_data_analysis_permission_unset';
    case AdministrationDataAnalysisPermissionSet = 'administration_data_analysis_permission_set';
    case AdministrationDetailsEdited = 'administration_details_edited';
    case AdministrationIdVerifiedForBankingAuthorizationRequirementActivated = 'administration_id_verified_for_banking_authorization_requirement_activated';
    case AdministrationMoneybirdBankingRequested = 'administration_moneybird_banking_requested';
    case AdministrationMoneybirdBankingTaxInformationSent = 'administration_moneybird_banking_tax_information_sent';
    case AdministrationMoneybirdPaymentsActivated = 'administration_moneybird_payments_activated';
    case AdministrationPaymentsWithoutProofActivated = 'administration_payments_without_proof_activated';
    case AdministrationPaymentsWithoutProofDeactivated = 'administration_payments_without_proof_deactivated';
    case AdministrationUpdatePeriodLockedUntil = 'administration_update_period_locked_until';
    case AdministrationLegacyTaxNumberUpdated = 'administration_legacy_tax_number_updated';

    case AdviserUpdated = 'adviser_updated';
    case AdviserCreated = 'adviser_created';
    case AdviserDeleted = 'adviser_deleted';
    case AdviserUpdatedPhoto = 'adviser_updated_photo';
    case AdviserEmailConceptStateSent = 'adviser_email_concept_state_sent';
    case AdviserEmailPublishedStateSent = 'adviser_email_published_state_sent';
    case AdviserExperienceCreated = 'adviser_experience_created';
    case AdviserExperienceUpdated = 'adviser_experience_updated';
    case AdviserExperienceDeleted = 'adviser_experience_deleted';
    case AdviserEducationCreated = 'adviser_education_created';
    case AdviserEducationUpdated = 'adviser_education_updated';
    case AdviserEducationDeleted = 'adviser_education_deleted';
    case AdviserCompanyCreated = 'adviser_company_created';
    case AdviserCompanyUpdated = 'adviser_company_updated';
    case AdviserCompanyPhoto = 'adviser_company_photo';
    case AdviserCompanyLocationCreated = 'adviser_company_location_created';
    case AdviserCompanyLocationDeleted = 'adviser_company_location_deleted';
    case AdviserCompanyReviewDeleted = 'adviser_company_review_deleted';
    case AdvisersLocationCreated = 'advisers_location_created';
    case AdvisersLocationDeleted = 'advisers_location_deleted';

    case AdyenBankingBankTransferPermissionCreated = 'adyen_banking_bank_transfer_permission_created';
    case AdyenBankingBankTransferPermissionRevoked = 'adyen_banking_bank_transfer_permission_revoked';
    case AdyenPaymentInstrumentCreated = 'adyen_payment_instrument_created';
    case AdyenPaymentInstrumentUpdated = 'adyen_payment_instrument_updated';
    case AdyenPaymentInstrumentActivated = 'adyen_payment_instrument_activated';
    case AdyenPaymentInstrumentSuspended = 'adyen_payment_instrument_suspended';

    case CompanyAssetsAssetCreated = 'company_assets_asset_created';
    case CompanyAssetsAssetDestroyed = 'company_assets_asset_destroyed';
    case CompanyAssetsAssetUpdated = 'company_assets_asset_updated';
    case CompanyAssetsDisposalCreated = 'company_assets_disposal_created';
    case CompanyAssetsDisposalDestroyed = 'company_assets_disposal_destroyed';
    case CompanyAssetsSourceCreated = 'company_assets_source_created';
    case CompanyAssetsSourceDestroyed = 'company_assets_source_destroyed';
    case CompanyAssetsValueChangesLinearCreated = 'company_assets_value_changes_linear_created';
    case CompanyAssetsValueChangesLinearDestroyed = 'company_assets_value_changes_linear_destroyed';
    case CompanyAssetsValueChangesArbitraryCreated = 'company_assets_value_changes_arbitrary_created';
    case CompanyAssetsValueChangesArbitraryDestroyed = 'company_assets_value_changes_arbitrary_destroyed';
    case CompanyAssetsValueChangesDisvestmentCreated = 'company_assets_value_changes_divestment_created';
    case CompanyAssetsValueChangesDisvestmentDestroyed = 'company_assets_value_changes_divestment_destroyed';
    case CompanyAssetsValueChangesFullDepreciationCreated = 'company_assets_value_changes_full_depreciation_created';
    case CompanyAssetsValueChangesFullDepreciationDestroyed = 'company_assets_value_changes_full_depreciation_destroyed';
    case CompanyAssetsValueChangesManualCreated = 'company_assets_value_changes_manual_created';
    case CompanyAssetsValueChangesManualDestroyed = 'company_assets_value_changes_manual_destroyed';
    case CompanyAssetsValueChangePlanCreated = 'company_assets_value_change_plan_created';
    case CompanyAssetsValueChangePlanDestroyed = 'company_assets_value_change_plan_destroyed';
    case CompanyAssetsValueChangePlanUpdated = 'company_assets_value_change_plan_updated';
    case CompanyAssetsValueChangePlanDeactivated = 'company_assets_value_change_plan_deactivated';
    case CompanyAssetsValueChangePlanActivated = 'company_assets_value_change_plan_activated';

    case BookingRuleCreated = 'booking_rule_created';
    case BookingRuleUpdated = 'booking_rule_updated';
    case BookingRuleDestroyed = 'booking_rule_destroyed';

    case ChangedIbanSendEmail = 'changed_iban_send_email';

    case ContactIsTrusted = 'contact_is_trusted';
    case ContactIsNotTrusted = 'contact_is_not_trusted';
    case ContactArchived = 'contact_archived';
    case ContactActivated = 'contact_activated';
    case ContactChanged = 'contact_changed';
    case ContactCreated = 'contact_created';
    case ContactCreatedFromCheckoutOrder = 'contact_created_from_checkout_order';
    case ContactDestroyed = 'contact_destroyed';
    case ContactMandateRequestFailed = 'contact_mandate_request_failed';
    case ContactMandateRequestInitiated = 'contact_mandate_request_initiated';
    case ContactMandateRequestSucceeded = 'contact_mandate_request_succeeded';
    case ContactMandateRequestUrlObtained = 'contact_mandate_request_url_obtained';
    case ContactMerged = 'contact_merged';
    case ContactOnlineAuthorizationLinkRequested = 'contact_online_authorization_link_requested';
    case ContactPaidSubscriptionChangedToSponsored = 'contact_paid_subscription_changed_to_sponsored';
    case ContactPersonCreated = 'contact_person_created';
    case ContactPersonDestroyed = 'contact_person_destroyed';
    case ContactPersonUpdated = 'contact_person_updated';
    case ContactSponsoredSubscriptionLinkRequested = 'contact_sponsored_subscription_link_requested';

    case CreditInvoiceCreatedFromOriginal = 'credit_invoice_created_from_original';

    case CustomerInvited = 'customer_invited';

    case DefaultIdentityUpdated = 'default_identity_updated';
    case DefaultIdentityVerificationDocumentUploaded = 'default_identity_verification_document_uploaded';
    case DefaultTaxRateCreated = 'default_tax_rate_created';

    case DirectBankLinkActivated = 'direct_bank_link_activated';
    case DirectDebitIncomingMandateCreated = 'direct_debit_incoming_mandate_created';
    case DirectDebitIncomingMandateUpdated = 'direct_debit_incoming_mandate_updated';
    case DirectDebitTransactionCreated = 'direct_debit_transaction_created';
    case DirectDebitTransactionDeleted = 'direct_debit_transaction_deleted';

    case DocumentAttachmentSkipped = 'document_attachment_skipped';
    case DocumentCreatedFromOriginal = 'document_created_from_original';
    case DocumentDestroyed = 'document_destroyed';
    case DocumentDetailsPredictionAdded = 'document_details_prediction_added';
    case DocumentExpired = 'document_expired';
    case DocumentRecurred = 'document_recurred';
    case DocumentSaved = 'document_saved';
    case DocumentSavedFromEmail = 'document_saved_from_email';
    case DocumentSavedFromSi = 'document_saved_from_si';
    case DocumentStyleCreated = 'document_style_created';
    case DocumentStyleDestroyed = 'document_style_destroyed';
    case DocumentStyleUpdated = 'document_style_updated';
    case DocumentUpdated = 'document_updated';

    case EmailDomainDeactivated = 'email_domain_deactivated';
    case EmailDomainValidated = 'email_domain_validated';

    case EstimateAcceptedContact = 'estimate_accepted_contact';
    case EstimateBilled = 'estimate_billed';
    case EstimateCreated = 'estimate_created';
    case EstimateCreatedFromOriginal = 'estimate_created_from_original';
    case EstimateCreatedFromOriginalInvoice = 'estimate_created_from_original_invoice';
    case EstimateDestroyed = 'estimate_destroyed';
    case EstimateMarkAccepted = 'estimate_mark_accepted';
    case EstimateMarkArchived = 'estimate_mark_archived';
    case EstimateMarkBilled = 'estimate_mark_billed';
    case EstimateMarkLate = 'estimate_mark_late';
    case EstimateMarkOpen = 'estimate_mark_open';
    case EstimateMarkRejected = 'estimate_mark_rejected';
    case EstimateSendEmail = 'estimate_send_email';
    case EstimateSendManually = 'estimate_send_manually';
    case EstimateSendPost = 'estimate_send_post';
    case EstimateSendPostCancelled = 'estimate_send_post_cancelled';
    case EstimateSendPostConfirmation = 'estimate_send_post_confirmation';
    case EstimateSignedSender = 'estimate_signed_sender';
    case EstimateStateChangedToLate = 'estimate_state_changed_to_late';
    case EstimateUpdated = 'estimate_updated';

    case ExternalSalesInvoiceCreated = 'external_sales_invoice_created';
    case ExternalSalesInvoiceDestroyed = 'external_sales_invoice_destroyed';
    case ExternalSalesInvoiceMarkedAsDubious = 'external_sales_invoice_marked_as_dubious';
    case ExternalSalesInvoiceMarkedAsUncollectible = 'external_sales_invoice_marked_as_uncollectible';
    case ExternalSalesInvoiceUpdated = 'external_sales_invoice_updated';
    case ExternalSalesInvoiceStateChangedToLate = 'external_sales_invoice_state_changed_to_late';
    case ExternalSalesInvoiceStateChangedToOpen = 'external_sales_invoice_state_changed_to_open';
    case ExternalSalesInvoiceStateChangedToPaid = 'external_sales_invoice_state_changed_to_paid';
    case ExternalSalesInvoiceStateChangedToUncollectible = 'external_sales_invoice_state_changed_to_uncollectible';

    case FeaturePreferenceOptIn = 'feature_preference_opt_in';
    case FeaturePreferenceOptOut = 'feature_preference_opt_out';

    case FeedEntrySnoozed = 'feed_entry_snoozed';
    case FeedEntryUnsnoozed = 'feed_entry_unsnoozed';

    case FinancialAccountActivated = 'financial_account_activated';
    case FinancialAccountCreated = 'financial_account_created';
    case FinancialAccountDeactivated = 'financial_account_deactivated';
    case FinancialAccountDestroyed = 'financial_account_destroyed';
    case FinancialAccountBankLinkCreated = 'financial_account_bank_link_created';
    case FinancialAccountBankLinkDestroyed = 'financial_account_bank_link_destroyed';
    case FinancialAccountBankLinkUpdated = 'financial_account_bank_link_updated';
    case FinancialAccountRenamed = 'financial_account_renamed';

    case FinancialStatementCreated = 'financial_statement_created';
    case FinancialStatementDestroyed = 'financial_statement_destroyed';
    case FinancialStatementUpdated = 'financial_statement_updated';

    case GoalCompleted = 'goal_completed';
    case GoalUncompleted = 'goal_uncompleted';

    case IdentityCreated = 'identity_created';
    case IdentityDestroyed = 'identity_destroyed';
    case IdentityUpdated = 'identity_updated';

    case IntraCommunityTransactionsDeclarationCreated = 'intra_community_transactions_declaration_created';
    case IntraCommunityTransactionsDeclarationReceived = 'intra_community_transactions_declaration_received';

    case LedgerAccountActivated = 'ledger_account_activated';
    case LedgerAccountBookingCreated = 'ledger_account_booking_created';
    case LedgerAccountBookingDestroyed = 'ledger_account_booking_destroyed';
    case LedgerAccountCreated = 'ledger_account_created';
    case LedgerAccountDeactivated = 'ledger_account_deactivated';
    case LedgerAccountDestroyed = 'ledger_account_destroyed';
    case LedgerAccountUpdated = 'ledger_account_updated';

    case LegalTermsAcceptationCreated = 'legal_terms_acceptation_created';
    case LegalTermsAcceptationDestroyed = 'legal_terms_acceptation_destroyed';
    case LegalTermsAcceptationEmailDeliveryFailed = 'legal_terms_acceptation_email_delivery_failed';
    case LegalTermsAcceptationEmailInvalidAddress = 'legal_terms_acceptation_email_invalid_address';
    case LegalTermsAcceptationEmailInvalidAttachment = 'legal_terms_acceptation_email_invalid_attachment';
    case LegalTermsAcceptationEmailMarkedAsSpam = 'legal_terms_acceptation_email_marked_as_spam';
    case LegalTermsAcceptationEmailPayloadTooLarge = 'legal_terms_acceptation_email_payload_too_large';
    case LegalTermsAcceptationEmailPreviouslyBounced = 'legal_terms_acceptation_email_previously_bounced';
    case LegalTermsAcceptationEmailSenderLimit = 'legal_terms_acceptation_email_sender_limit';
    case LegalTermsAcceptationEmailSent = 'legal_terms_acceptation_email_sent';
    case LegalTermsAcceptationUpdated = 'legal_terms_acceptation_updated';

    case MollieCredentialCreated = 'mollie_credential_created';
    case MollieCredentialDestroyed = 'mollie_credential_destroyed';

    case MoneybirdBankingTransferInitiated = 'moneybird_banking_transfer_initiated';
    case MoneybirdBankingTransferFailed = 'moneybird_banking_transfer_failed';

    case MultiFactor = 'multi_factor_required';

    case NoteCreated = 'note_created';
    case NoteDestroyed = 'note_destroyed';

    case OrderCreated = 'order_created';

    case PasswordChanged = 'password_changed';

    case PaymentDestroyed = 'payment_destroyed';
    case PaymentLinkedToFinancialMutation = 'payment_linked_to_financial_mutation';
    case PaymentRegistered = 'payment_registered';
    case PaymentSendEmail = 'payment_send_email';
    case PaymentMethodEdited = 'payment_method_edited';
    case PaymentTransactionAuthorized = 'payment_transaction_authorized';
    case PaymentTransactionAwaitingAuthorization = 'payment_transaction_awaiting_authorization';
    case PaymentTransactionBatchCancelled = 'payment_transaction_batch_cancelled';
    case PaymentTransactionBatchCreated = 'payment_transaction_batch_created';
    case PaymentTransactionExecuting = 'payment_transaction_executing';
    case PaymentTransactionPaid = 'payment_transaction_paid';
    case PaymentTransactionPending = 'payment_transaction_pending';
    case PaymentTransactionRejected = 'payment_transaction_rejected';
    case PaymentTransactionTechnicallyValidated = 'payment_transaction_technically_validated';

    case PontoConnected = 'ponto_connected';
    case PontoDisconnected = 'ponto_disconnected';
    case PontoDirectBankLinkActivated = 'ponto_direct_bank_link_activated';
    case PontoDirectBankLinkExpired = 'ponto_direct_bank_link_expired';

    case ProductActivated = 'product_activated';
    case ProductCreated = 'product_created';
    case ProductDeactivated = 'product_deactivated';
    case ProductDestroyed = 'product_destroyed';
    case ProductUpdated = 'product_updated';

    case ProjectActivated = 'project_activated';
    case ProjectCreated = 'project_created';
    case ProjectArchived = 'project_archived';
    case ProjectDestroyed = 'project_destroyed';
    case ProjectUpdated = 'project_updated';

    case PurchaseTransactionAddedToBatch = 'purchase_transaction_added_to_batch';
    case PurchaseTransactionAuthorized = 'purchase_transaction_authorized';
    case PurchaseTransactionAwaitingAuthorization = 'purchase_transaction_awaiting_authorization';
    case PurchaseTransactionBatchCancelled = 'purchase_transaction_batch_cancelled';
    case PurchaseTransactionBatchCreated = 'purchase_transaction_batch_created';
    case PurchaseTransactionCreated = 'purchase_transaction_created';
    case PurchaseTransactionDeleted = 'purchase_transaction_deleted';
    case PurchaseTransactionExecuting = 'purchase_transaction_executing';
    case PurchaseTransactionPaid = 'purchase_transaction_paid';
    case PurchaseTransactionPending = 'purchase_transaction_pending';
    case PurchaseTransactionRejected = 'purchase_transaction_rejected';
    case PurchaseTransactionTechnicallyValidated = 'purchase_transaction_technically_validated';

    case RecurringSalesInvoiceAutoSendForcefullyDisabled = 'recurring_sales_invoice_auto_send_forcefully_disabled';
    case RecurringSalesInvoiceCreated = 'recurring_sales_invoice_created';
    case RecurringSalesInvoiceCreatedFromOriginal = 'recurring_sales_invoice_created_from_original';
    case RecurringSalesInvoiceCreatedFromOriginalRecurring = 'recurring_sales_invoice_created_from_original_recurring';
    case RecurringSalesInvoiceCreatingSkippedDueToLimits = 'recurring_sales_invoice_creating_skipped_due_to_limits';
    case RecurringSalesInvoiceDeactivated = 'recurring_sales_invoice_deactivated';
    case RecurringSalesInvoiceDestroyed = 'recurring_sales_invoice_destroyed';
    case RecurringSalesInvoiceInvoiceCreated = 'recurring_sales_invoice_invoice_created';
    case RecurringSalesInvoiceReachedDesiredCountOfInvoices = 'recurring_sales_invoice_reached_desired_count_of_invoices';
    case RecurringSalesInvoiceStartedAutoSend = 'recurring_sales_invoice_started_auto_send';
    case RecurringSalesInvoiceStoppedAutoSend = 'recurring_sales_invoice_stopped_auto_send';
    case RecurringSalesInvoiceUpdated = 'recurring_sales_invoice_updated';

    case RuleActivated = 'rule_activated';
    case RuleUpdated = 'rule_updated';
    case RuleDeactivated = 'rule_deactivated';
    case RuleDestroyed = 'rule_destroyed';

    case SalesInvoiceCreated = 'sales_invoice_created';
    case SalesInvoiceCreatedBasedOnEstimate = 'sales_invoice_created_based_on_estimate';
    case SalesInvoiceCreatedBasedOnRecurring = 'sales_invoice_created_based_on_recurring';
    case SalesInvoiceCreatedBasedOnSubscription = 'sales_invoice_created_based_on_subscription';
    case SalesInvoiceCreatedFromCheckoutOrder = 'sales_invoice_created_from_checkout_order';
    case SalesInvoiceCreatedFromOriginal = 'sales_invoice_created_from_original';
    case SalesInvoiceDestroyed = 'sales_invoice_destroyed';
    case SalesInvoiceMarkedAsDubious = 'sales_invoice_marked_as_dubious';
    case SalesInvoiceMarkedAsUncollectible = 'sales_invoice_marked_as_uncollectible';
    case SalesInvoiceMerged = 'sales_invoice_merged';
    case SalesInvoiceMergedWithRecurringSalesInvoice = 'sales_invoice_merged_with_recurring_sales_invoice';
    case SalesInvoicePaused = 'sales_invoice_paused';
    case SalesInvoiceRevertDubious = 'sales_invoice_revert_dubious';
    case SalesInvoiceRevertUncollectible = 'sales_invoice_revert_uncollectible';
    case SalesInvoiceSendEmail = 'sales_invoice_send_email';
    case SalesInvoiceSendManually = 'sales_invoice_send_manually';
    case SalesInvoiceSendPost = 'sales_invoice_send_post';
    case SalesInvoiceSendPostConfirmation = 'sales_invoice_send_post_confirmation';
    case SalesInvoiceSendPostCancelled = 'sales_invoice_send_post_cancelled';
    case SalesInvoiceSendReminderEmail = 'sales_invoice_send_reminder_email';
    case SalesInvoiceSendReminderManually = 'sales_invoice_send_reminder_manually';
    case SalesInvoiceSendReminderPost = 'sales_invoice_send_reminder_post';
    case SalesInvoiceSendReminderPostConfirmation = 'sales_invoice_send_reminder_post_confirmation';
    case SalesInvoiceSendSi = 'sales_invoice_send_si';
    case SalesInvoiceSendSiDelivered = 'sales_invoice_send_si_delivered';
    case SalesInvoiceSendSiError = 'sales_invoice_send_si_error';
    case SalesInvoiceSendToPayt = 'sales_invoice_send_to_payt';
    case SalesInvoiceStateChangedToDraft = 'sales_invoice_state_changed_to_draft';
    case SalesInvoiceStateChangedToLate = 'sales_invoice_state_changed_to_late';
    case SalesInvoiceStateChangedToOpen = 'sales_invoice_state_changed_to_open';
    case SalesInvoiceStateChangedToPaid = 'sales_invoice_state_changed_to_paid';
    case SalesInvoiceStateChangedToPendingPayment = 'sales_invoice_state_changed_to_pending_payment';
    case SalesInvoiceStateChangedToReminded = 'sales_invoice_state_changed_to_reminded';
    case SalesInvoiceStateChangedToScheduled = 'sales_invoice_state_changed_to_scheduled';
    case SalesInvoiceStateChangedToUncollectible = 'sales_invoice_state_changed_to_uncollectible';
    case SalesInvoiceUnpaused = 'sales_invoice_unpaused';
    case SalesInvoiceUpdated = 'sales_invoice_updated';

    case SendPaymentEmail = 'send_payment_email';
    case SendPaymentUnsuccessfulEmail = 'send_payment_unsuccessful_email';

    case SepaDirectDebitLimitUpdated = 'sepa_direct_debit_limit_updated';

    case SmartTransferRuleCreated = 'smart_transfer_rule_created';
    case SmartTransferRuleUpdated = 'smart_transfer_rule_updated';
    case SmartTransferTriggerCreated = 'smart_transfer_trigger_created';
    case SmartTransferTriggerEnabled = 'smart_transfer_trigger_enabled';
    case SmartTransferTriggerDisabled = 'smart_transfer_trigger_disabled';
    case SmartTransferTriggerUpdated = 'smart_transfer_trigger_updated';

    case SubgoalAssigned = 'subgoal_assigned';
    case SubgoalCompleted = 'subgoal_completed';
    case SubgoalUncompleted = 'subgoal_uncompleted';

    case SubscriptionCancelled = 'subscription_cancelled';
    case SubscriptionCreated = 'subscription_created';
    case SubscriptionDestroyed = 'subscription_destroyed';
    case SubscriptionEdited = 'subscription_edited';
    case SubscriptionResumed = 'subscription_resumed';
    case SubscriptionUpdated = 'subscription_updated';
    case SubscriptionTemplateActivated = 'subscription_template_activated';
    case SubscriptionTemplateCreated = 'subscription_template_created';
    case SubscriptionTemplateDestroyed = 'subscription_template_destroyed';
    case SubscriptionTemplateDeactivated = 'subscription_template_deactivated';
    case SubscriptionTemplateUpdated = 'subscription_template_updated';

    case TaskListsListCreated = 'task_lists_list_created';
    case TaskListsListDestroyed = 'task_lists_list_destroyed';
    case TaskListsListUpdated = 'task_lists_list_updated';
    case TaskListsListTemplateCreated = 'task_lists_list_template_created';
    case TaskListsListTemplateDestroyed = 'task_lists_list_template_destroyed';
    case TaskListsListTemplateUpdated = 'task_lists_list_template_updated';
    case TaskListsTaskCompleted = 'task_lists_task_completed';
    case TaskListsTaskCreated = 'task_lists_task_created';
    case TaskListsTaskDestroyed = 'task_lists_task_destroyed';
    case TaskListsTaskReopened = 'task_lists_task_reopened';
    case TaskListsTaskUpdated = 'task_lists_task_updated';

    case TaxRateActivated = 'tax_rate_activated';
    case TaxRateCreated = 'tax_rate_created';
    case TaxRateDeactivated = 'tax_rate_deactivated';
    case TaxRateDestroyed = 'tax_rate_destroyed';
    case TaxRateUpdated = 'tax_rate_updated';

    case TimeEntryCreated = 'time_entry_created';
    case TimeEntryDestroyed = 'time_entry_destroyed';
    case TimeEntrySalesInvoiceCreated = 'time_entry_sales_invoice_created';
    case TimeEntryUpdated = 'time_entry_updated';

    case TodoCompleted = 'todo_completed';
    case TodoCreated = 'todo_created';
    case TodoDestroyed = 'todo_destroyed';
    case TodoOpened = 'todo_opened';

    case UltimateBeneficialOwnerVerificationDocumentUploaded = 'ultimate_beneficial_owner_verification_document_uploaded';
    case UltimateBeneficialOwnerCreated = 'ultimate_benificial_owner_created';
    case UltimateBeneficialOwnerUpdated = 'ultimate_benificial_owner_updated';

    case UserInvited = 'user_invited';
    case UserInvitedForCall = 'user_invited_for_call';
    case UserRemoved = 'user_removed';

    case VatReturnCreated = 'vat_return_created';
    case VatReturnReceived = 'vat_return_received';
    case VatReturnPaid = 'vat_return_paid';
    case VatSuppletionCreated = 'vat_suppletion_created';
    case VatSuppletionReceived = 'vat_suppletion_received';
    case VatSuppletionPaid = 'vat_suppletion_paid';

    case VerificationDestroyed = 'verification_destroyed';

    case WorkflowCreated = 'workflow_created';
    case WorkflowDeactivated = 'workflow_deactivated';
    case WorkflowDestroyed = 'workflow_destroyed';
    case WorkflowUpdated = 'workflow_updated';
}
