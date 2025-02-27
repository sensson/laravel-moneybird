<?php

use Saloon\Helpers\OAuth2\OAuthConfig;
use Sensson\Moneybird\Connectors\AuthConnector;

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
