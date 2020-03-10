<?php

/**
 * MumieSSOToken is used as authentication method for SSO to MUMIE servers
 */
class MumieSSOToken extends SimpleORMap
{
    /**
     * configure
     *
     * @param  mixed $config
     * @return void
     */
    protected static function configure($config = array())
    {
        $config['db_table'] = 'mumie_sso_tokens';
        parent::configure($config);
    }
    
    /**
     * Find a MumieSSOToken by (hashed) user
     *
     * @param  string $user
     * @return MumieSSOToken
     */
    public static function findByUser($user)
    {
        return MumieSSOToken::findOneBySql("the_user = ?", array($user));
    }
    
    /**
     * Find a MumieSSOToken by a token string
     *
     * @param  string $token
     * @return MumieSSOToken
     */
    public static function findByToken($token)
    {
        return MumieSSOToken::findOneBySql("token = ?", array($token));
    }
}
