<?php
/**
 * Created by PhpStorm.
 * User: Zorro
 * Date: 6/20/2016
 * Time: 3:07 PM
 */

namespace App\OAuth\Services;


use OAuth\Common\Storage\Exception\TokenNotFoundException;
use OAuth\Common\Storage\TokenStorageInterface;
use OAuth\Common\Token\TokenInterface;
use Session;

class LaravelSessionStorage implements TokenStorageInterface
{

    public function __construct(
        $startSession = true,
        $sessionVariableName = 'lusitanian-oauth-token',
        $stateVariableName = 'lusitanian-oauth-state'
    )
    {
        $this->startSession = $startSession;
        $this->sessionVariableName = $sessionVariableName;
        $this->stateVariableName = $stateVariableName;
        if (!\Session::has($sessionVariableName)) {
            \Session::put($sessionVariableName, []);;
        }
        if (!\Session::has($stateVariableName)) {
            \Session::put($stateVariableName, []);;
        }
    }

    /**
     * @param string $service
     *
     * @return TokenInterface
     *
     * @throws TokenNotFoundException
     */
    public function retrieveAccessToken($service)
    {
        if ($this->hasAccessToken($service)) {
            return unserialize(\Session::get($this->sessionVariableName . '.' . $service));
        }

        throw new TokenNotFoundException('Token not found in session, are you sure you stored it?');
    }

    /**
     * @param string $service
     * @param TokenInterface $token
     *
     * @return TokenStorageInterface
     */
    public function storeAccessToken($service, TokenInterface $token)
    {
        $serializedToken = serialize($token);

        if (Session::has($this->sessionVariableName)
            && is_array(Session::get($this->sessionVariableName))
        ) {
            Session::put($this->sessionVariableName . '.' . $service, $serializedToken);
        } else {
            Session::put($this->sessionVariableName, array(
                $service => $serializedToken,
            ));
        }

        // allow chaining
        return $this;
    }

    /**
     * @param string $service
     *
     * @return bool
     */
    public function hasAccessToken($service)
    {
        return Session::get($this->sessionVariableName . '.' . $service, false);
    }

    /**
     * Delete the users token. Aka, log out.
     *
     * @param string $service
     *
     * @return TokenStorageInterface
     */
    public function clearToken($service)
    {
        Session::remove($this->sessionVariableName . '.' . $service);
    }

    /**
     * Delete *ALL* user tokens. Use with care. Most of the time you will likely
     * want to use clearToken() instead.
     *
     * @return TokenStorageInterface
     */
    public function clearAllTokens()
    {
        Session::remove($this->sessionVariableName);
    }

    /**
     * Store the authorization state related to a given service
     *
     * @param string $service
     * @param string $state
     *
     * @return TokenStorageInterface
     */
    public function storeAuthorizationState($service, $state)
    {
        if (Session::has($this->stateVariableName)
            && is_array(Session::get($this->stateVariableName))
        ) {
            Session::put($this->stateVariableName . '.' . $service, $state);
        } else {
            Session::put($this->stateVariableName, array(
                $service => $state,
            ));
        }

        // allow chaining
        return $this;
    }

    /**
     * Check if an authorization state for a given service exists
     *
     * @param string $service
     *
     * @return bool
     */
    public function hasAuthorizationState($service)
    {
        return Session::get($this->stateVariableName . '.' . $service);
    }

    /**
     * Retrieve the authorization state for a given service
     *
     * @param string $service
     *
     * @return string
     */
    public function retrieveAuthorizationState($service)
    {
        if ($this->hasAuthorizationState($service)) {
            return unserialize(\Session::get($this->stateVariableName . '.' . $service));
        }

        throw new TokenNotFoundException('Token not found in session, are you sure you stored it?');
    }

    /**
     * Clear the authorization state of a given service
     *
     * @param string $service
     *
     * @return TokenStorageInterface
     */
    public function clearAuthorizationState($service)
    {
        Session::remove($this->stateVariableName . '.' . $service);
    }

    /**
     * Delete *ALL* user authorization states. Use with care. Most of the time you will likely
     * want to use clearAuthorization() instead.
     *
     * @return TokenStorageInterface
     */
    public function clearAllAuthorizationStates()
    {
        Session::remove($this->stateVariableName);
    }
}