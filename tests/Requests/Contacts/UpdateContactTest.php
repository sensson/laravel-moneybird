<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Data\Contact;
use Sensson\Moneybird\Enums\DeliveryMethod;
use Sensson\Moneybird\Requests\Contacts\UpdateContact;

it('updates a contact', function () {
    $contact = Contact::from([
        'company_name' => 'Updated Acme Inc.',
        'firstname' => 'Jane',
        'lastname' => 'Smith',
        'delivery_method' => DeliveryMethod::Email,
        'email' => 'jane@example.com',
        'send_invoices_to_email' => 'billing@updated-acme.com',
        'send_estimates_to_email' => 'billing@updated-acme.com',
    ]);

    $mockClient = new MockClient([
        UpdateContact::class => MockResponse::make([
            ...$contact->toArray(),
            'id' => '1',
            'administration_id' => '123456789',
        ]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $response = $connector->send(new UpdateContact('1', $contact));
    $mockClient->assertSent(UpdateContact::class);

    $result = $response->dto();

    expect($result)->toBeInstanceOf(Contact::class)
        ->and($result->id)->toBe('1')
        ->and($result->administration_id)->toBe('123456789')
        ->and($result->company_name)->toBe('Updated Acme Inc.')
        ->and($result->firstname)->toBe('Jane')
        ->and($result->lastname)->toBe('Smith')
        ->and($result->email)->toBe('jane@example.com')
        ->and($result->delivery_method)->toBe(DeliveryMethod::Email)
        ->and($result->send_invoices_to_email)->toBe('billing@updated-acme.com')
        ->and($result->send_estimates_to_email)->toBe('billing@updated-acme.com');
});
