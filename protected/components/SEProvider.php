<?php

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

class SEProvider extends AbstractProvider {

    /**
     * Api domain
     *
     * @var string
     */
    public $apiDomain = 'https://api.streamelements.com';
    public $scopes = [];

    /**
     * Get authorization url to begin OAuth flow
     *
     * @return string
     */
    public function getBaseAuthorizationUrl() {
        return $this->apiDomain . '/oauth2/authorize';
    }

    /**
     * Get access token url to retrieve token
     *
     * @param array $params
     *
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params) {
        return $this->apiDomain . '/oauth2/token';
    }

    /**
     * Get provider url to fetch user details
     *
     * @param AccessToken $token
     *
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token) {
        return $this->getAuthenticatedUrlForEndpoint('/kappa/v2/channels/me', $token);
    }

    /**
     * Get access token url to retrieve token
     *
     * @param AccessToken $token
     * @return bool
     */
    public function revoke(AccessToken $token) {
        return $this->getAuthenticatedRequest('post', $this->getAuthenticatedUrlForEndpoint('/oauth2/revoke', $token), $token);
    }

    /**
     * Get the full uri with appended oauth_token query string and client ID
     *
     * @param string $endpoint | with leading slash
     * @param AccessToken $token
     * @return string
     */
    public function getAuthenticatedUrlForEndpoint($endpoint, AccessToken $token) {
        return $this->apiDomain . $endpoint . '?token=' . $token->getToken() . '&client_id=' . $this->clientId;
    }

    /**
     * Get the full urls that do not require authentication
     *
     * @param $endpoint
     * @return string
     */
    public function getUrlForEndpoint($endpoint) {
        return $this->apiDomain . $endpoint;
    }

    /**
     * Returns the string that should be used to separate scopes when building
     * the URL for requesting an access token.
     *
     * @return string Scope separator
     */
    protected function getScopeSeparator() {
        return ' ';
    }

    /**
     * Get the default scopes used by this provider.
     *
     * This should not be a complete list of all scopes, but the minimum
     * required for the provider user interface!
     *
     * @return array
     */
    protected function getDefaultScopes() {
        return $this->scopes;
    }

    /**
     * Checks response
     *
     * @param ResponseInterface $response
     * @param array|string $data
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    protected function checkResponse(ResponseInterface $response, $data) {
        if ($response->getStatusCode() >= 400) {
            throw new Exception($response);
        } elseif (isset($data['error'])) {
            throw new Exception($response);
        }
    }

    /**
     * Generate a user object from a successful user details request.
     *
     * @param array $response
     * @param AccessToken $token
     * @return array
     */
    protected function createResourceOwner(array $response, AccessToken $token) {
        return ((array) $response);
    }

    /**
     * Since August 8th, 2016 Kraken requires a Client-ID header to be sent
     *
     * @return array
     */
    protected function getDefaultHeaders() {
        return [];
    }

    /**
     * Adds token to headers
     *
     * @param AccessToken $token
     * @return array
     */
    protected function getAuthorizationHeaders($token = null) {
        if (isset($token))
            return ['Authorization' => 'OAuth ' . $token->getToken()];
        return [];
    }

}
