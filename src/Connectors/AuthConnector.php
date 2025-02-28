<?php

namespace Sensson\Moneybird\Connectors;

use Saloon\Helpers\OAuth2\OAuthConfig;
use Saloon\Http\Connector;
use Saloon\Traits\OAuth2\AuthorizationCodeGrant;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class AuthConnector extends Connector
{
    use AlwaysThrowOnErrors;
    use AuthorizationCodeGrant;

    public function resolveBaseUrl(): string
    {
        return 'https://moneybird.com/oauth';
    }

    public function defaultOauthConfig(): OAuthConfig
    {
        return OAuthConfig::make()
            ->setClientId(config('moneybird.oauth.client_id'))
            ->setClientSecret(config('moneybird.oauth.client_secret'))
            ->setRedirectUri(config('moneybird.oauth.redirect_uri'))
            ->setDefaultScopes(config('moneybird.oauth.scopes'))
            ->setAuthorizeEndpoint('authorize')
            ->setTokenEndpoint('token');
    }
}
