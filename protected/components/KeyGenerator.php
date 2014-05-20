<?php

class KeyGenerator extends CApplicationComponent
{

    public $userKey = 'rSS8lcO2^/j5|\6%bCw!';
    public $passwordKey = '#hBR Wk5tL%c,HP:X`3U';
    public $iterations = 1337;
    public $bytes = 64;

    public function getPasswordKey(User $user)
    {
        return hash_pbkdf2("sha256", $user->password . $user->userid, $this->passwordKey, $this->iterations, $this->bytes);
    }

    public function getMailKey($mail)
    {
        return hash('sha256', $this->userKey . $mail);
    }

    /**
     * md5 hashen
     * @return string
     */
    public function getUniquKey()
    {
        return md5(uniqid(rand(), TRUE));
    }

}
