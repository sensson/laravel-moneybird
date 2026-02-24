<?php

use Saloon\Exceptions\Request\Statuses\UnauthorizedException;
use Saloon\Helpers\OAuth2\OAuthConfig;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\AuthConnector;
use Sensson\Moneybird\Exceptions\AccessTokenRevokedException;
use Sensson\Moneybird\Requests\Administrations\ListAdministrations;

test('auth connector has correct base url', function () {
    $connector = new AuthConnector;

    expect($connector->resolveBaseUrl())->toBe('https://moneybird.com/oauth');
});

test('auth connector has correct oauth config', function () {
    // Set test config values
    config(['moneybird.oauth.client_id' => 'test-client-id']);
    config(['moneybird.oauth.client_secret' => 'test-client-secret']);
    config(['moneybird.oauth.redirect_uri' => 'http://localhost/callback']);

    $connector = new AuthConnector;
    $oauthConfig = $connector->defaultOauthConfig();

    expect($oauthConfig)->toBeInstanceOf(OAuthConfig::class)
        ->and($oauthConfig->getClientId())->toBe('test-client-id')
        ->and($oauthConfig->getClientSecret())->toBe('test-client-secret')
        ->and($oauthConfig->getRedirectUri())->toBe('http://localhost/callback')
        ->and($oauthConfig->getAuthorizeEndpoint())->toBe('authorize')
        ->and($oauthConfig->getTokenEndpoint())->toBe('token');
});

it('throws AccessTokenRevokedException when access token is revoked', function () {
    $mockClient = new MockClient([
        ListAdministrations::class => MockResponse::make('access token revoked', 401),
    ]);

    $connector = (new AuthConnector)->withMockClient($mockClient);
    $connector->send(new ListAdministrations);
})->throws(AccessTokenRevokedException::class);

it('does not throw AccessTokenRevokedException for other 401 responses', function () {
    $mockClient = new MockClient([
        ListAdministrations::class => MockResponse::make('unauthorized', 401),
    ]);

    $connector = (new AuthConnector)->withMockClient($mockClient);
    $connector->send(new ListAdministrations);
})->throws(UnauthorizedException::class);
