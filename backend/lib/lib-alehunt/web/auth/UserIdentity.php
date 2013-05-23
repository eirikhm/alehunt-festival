<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;

    public function authenticate()
    {
        $user = User::model()->find('email = :email',array(':email' => $this->username));
        if($user && $user->password === md5($this->password))
        {
            $this->errorCode = self::ERROR_NONE;
            $this->_id       = $user->id;
        }
        else
        {
            $this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
        }
        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }
}