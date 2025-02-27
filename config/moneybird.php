<?php

return [
    'oauth' => [
        'client_id' => env('MONEYBIRD_CLIENT_ID'),
        'client_secret' => env('MONEYBIRD_CLIENT_SECRET'),
        'redirect_uri' => env('MONEYBIRD_REDIRECT_URI'),

        'scopes' => [
            'sales_invoices',
            'documents',
            'estimates',
            'bank',
            'time_entries',
            'settings',
        ],
    ],
];
