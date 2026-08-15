# Moneybird

[![Latest Version on Packagist](https://img.shields.io/packagist/v/sensson/laravel-moneybird.svg?style=flat-square)](https://packagist.org/packages/sensson/laravel-moneybird)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/sensson/laravel-moneybird/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/sensson/laravel-moneybird/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/sensson/laravel-moneybird/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/sensson/laravel-moneybird/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/sensson/laravel-moneybird.svg?style=flat-square)](https://packagist.org/packages/sensson/laravel-moneybird)

This package allows you to connect your Laravel application to the accounting
software by [Moneybird](https://www.moneybird.nl).

## Installation

You can install the package via composer:

```bash
composer require sensson/laravel-moneybird
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="moneybird-config"
```

## Usage

```php
$moneybirdAdministrationId = '<your-administration-id>';
Moneybird::administration($moneybirdAdministrationId)->contacts()->all();
```

### Authentication / OAuth2

You can use OAuth2 to authorize your application with Moneybird.

```php
$moneybird = Moneybird::auth();
$url = $moneybird->getAuthorizationUrl();

session()->put('moneybird.state', $moneybird->getState());

return redirect()->to($url);
```

And process the callback from Moneybird:

```php
$code = $request->string('code');
$state = $request->string('state');
$expected = session()->pull('moneybird.state');

$moneybird = Moneybird::auth();
$authorization = $moneybird->getAccessToken($code, $state, $expected);

// Store the $authorization details with a user or team
```

Both would typically be done in a custom controller. You can use the 
`$authorization` to call the Moneybird API:

```php
$auth = $this->moneybird_auth;

if ($auth->hasExpired()) {
    $auth = Moneybird::auth()->make()->refreshAccessToken($auth);
    // Save new auth with the tenant or user
}

Moneybird::make()->authenticate($auth);
```

## Resources

All resources are accessed through the `Moneybird` facade using the pattern:
`Moneybird::administration($administrationId)->resourceName()`

### Administrations

Get all administrations:

```php
$administrations = Moneybird::administrations()->all();
```

### Contacts

Get all contacts:

```php
$administrationId = 'your-administration-id';
$contacts = Moneybird::administration($administrationId)->contacts()->all();
```

Get contacts with pagination and filters:

```php
$contacts = Moneybird::administration($administrationId)->contacts()->all(
    perPage: 25,
    page: 1,
    query: 'search term',
    includeArchived: false,
    todo: 'todo filter'
);
```

Get a specific contact:

```php
$contact = Moneybird::administration($administrationId)
    ->contacts()
    ->get('contact-id');
```

Create a new contact:

```php
$contact = new Contact([
    'company_name' => 'Example Company',
    'firstname' => 'John',
    'lastname' => 'Doe'
]);
$createdContact = Moneybird::administration($administrationId)
    ->contacts()
    ->create($contact);
```

Update a contact:

```php
$updatedContact = Moneybird::administration($administrationId)
    ->contacts()
    ->update('contact-id', $contact);
```

### Custom Fields

Get all custom fields:

```php
$administrationId = 'your-administration-id';
$customFields = Moneybird::administration($administrationId)
    ->customFields()
    ->all();
```

### Financial Mutations

Get all financial mutations. The list is limited to 100 records and accepts
an optional Moneybird filter string:

```php
$administrationId = 'your-administration-id';
$mutations = Moneybird::administration($administrationId)
    ->financialMutations()
    ->all(filter: 'period:this_month,state:unprocessed');
```

Get a specific financial mutation:

```php
$mutation = Moneybird::administration($administrationId)
    ->financialMutations()
    ->get('financial-mutation-id');
```

To pull in more than 100 mutations, use synchronization. First retrieve the
id and version of every mutation matching a filter, then fetch the full
records in batches of up to 100:

```php
$versions = Moneybird::administration($administrationId)
    ->financialMutations()
    ->synchronization('period:this_month,mutation_type:debit');

$ids = $versions->pluck('id')->take(100)->all();

$mutations = Moneybird::administration($administrationId)
    ->financialMutations()
    ->getByIds($ids);
```

Moneybird does not allow filtering mutations by invoice. To find the mutations
that paid a sales invoice, inspect the payments on each mutation:

```php
foreach ($mutations as $mutation) {
    foreach ($mutation->payments as $payment) {
        if ($payment->invoice_type === 'SalesInvoice' && $payment->invoice_id === $invoiceId) {
            // ...
        }
    }
}
```

Link a booking to a mutation:

```php
$booking = new Booking([
    'booking_type' => 'LedgerAccount',
    'booking_id' => 'ledger-account-id',
    'price' => '10.00',
]);
Moneybird::administration($administrationId)
    ->financialMutations()
    ->linkBooking('financial-mutation-id', $booking);
```

Unlink a booking from a mutation:

```php
$booking = new Booking([
    'booking_type' => 'Payment',
    'booking_id' => 'payment-id',
]);
Moneybird::administration($administrationId)
    ->financialMutations()
    ->unlinkBooking('financial-mutation-id', $booking);
```

### Ledgers

Get all ledgers:

```php
$administrationId = 'your-administration-id';
$ledgers = Moneybird::administration($administrationId)->ledgers()->all();
```

Get a specific ledger:

```php
$ledger = Moneybird::administration($administrationId)
    ->ledgers()
    ->get('ledger-id');
```

Create a new ledger:

```php
$ledger = new Ledger([
    'name' => 'New Ledger',
    'account_type' => AccountType::Expenses
]);
$createdLedger = Moneybird::administration($administrationId)
    ->ledgers()
    ->create($ledger, 'rgs-code');
```

Update a ledger:

```php
$updatedLedger = Moneybird::administration($administrationId)
    ->ledgers()
    ->update('ledger-id', $ledger, 'rgs-code');
```

Delete a ledger:

```php
Moneybird::administration($administrationId)
    ->ledgers()
    ->delete('ledger-id');
```

### Sales Invoices

Get all sales invoices:

```php
$administrationId = 'your-administration-id';
$invoices = Moneybird::administration($administrationId)
    ->salesInvoices()
    ->all();
```

Get a specific sales invoice:

```php
$invoice = Moneybird::administration($administrationId)
    ->salesInvoices()
    ->get('invoice-id');
```

Find invoice by invoice ID:

```php
$invoice = Moneybird::administration($administrationId)
    ->salesInvoices()
    ->findByInvoiceId('2023-001');
```

Create a new sales invoice:

```php
$invoice = new SalesInvoice([
    'contact_id' => 'contact-id',
    'invoice_date' => '2023-12-01'
]);
$createdInvoice = Moneybird::administration($administrationId)
    ->salesInvoices()
    ->create($invoice);
```

Update a sales invoice:

```php
$updatedInvoice = Moneybird::administration($administrationId)
    ->salesInvoices()
    ->update('invoice-id', $invoice);
```

Delete a sales invoice:

```php
Moneybird::administration($administrationId)
    ->salesInvoices()
    ->delete('invoice-id');
```

Download invoice as PDF:

```php
$pdfContent = Moneybird::administration($administrationId)
    ->salesInvoices()
    ->downloadPdf('invoice-id');
```

Download invoice as UBL:

```php
$ublContent = Moneybird::administration($administrationId)
    ->salesInvoices()
    ->downloadUbl('invoice-id');
```

Send invoice:

```php
$sentInvoice = Moneybird::administration($administrationId)
    ->salesInvoices()
    ->send('invoice-id', DeliveryMethod::Email);
```

### Tax Rates

Get all tax rates:

```php
$administrationId = 'your-administration-id';
$taxRates = Moneybird::administration($administrationId)->taxRates()->all();
```

Get tax rates with pagination and filters:

```php
$taxRates = Moneybird::administration($administrationId)->taxRates()->all(
    perPage: 25,
    page: 1,
    filter: 'active'
);
```

### Webhooks

Get all webhooks:

```php
$administrationId = 'your-administration-id';
$webhooks = Moneybird::administration($administrationId)->webhooks()->all();
```

Create a new webhook:

```php
$webhook = new Webhook(
    url: 'https://example.com/webhook',
    enabled_events: [WebhookEvent::SalesInvoiceCreated],
);

$createdWebhook = Moneybird::administration($administrationId)
    ->webhooks()
    ->create($webhook);
```

Store `$createdWebhook->secret` securely when the webhook is created. Moneybird
only returns this signing secret in the creation response.

Delete a webhook:

```php
Moneybird::administration($administrationId)
    ->webhooks()
    ->delete('webhook-id');
```

Verify that a webhook was sent by Moneybird using the raw request body, the
`Moneybird-Signature` header, and the signing secret returned when the webhook
was created:

```php
use Sensson\Moneybird\MoneybirdWebhookSignature;

$isValid = MoneybirdWebhookSignature::isValid(
    payload: $rawRequestBody,
    header: $moneybirdSignatureHeader,
    secret: $webhookSigningSecret,
);
```

Signatures older or newer than five minutes are rejected by default. Pass a
different number of seconds as the `tolerance` argument when needed.

### Workflows

Get all workflows:

```php
$administrationId = 'your-administration-id';
$workflows = Moneybird::administration($administrationId)
    ->workflows()
    ->all();
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Sensson](https://github.com/sensson)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
