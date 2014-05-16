<?php

/**
 * Description of LoginTest
 *
 * @author maurice
 */
class LoginTest extends WebTestCase
{

    public $modelName = 'User';

    /**
     * @dataProvider providerLoginWrong
     * @param string $user
     * @param string $password
     */
    public function testLoginWrong($user, $password)
    {
        $this->visitLogin();
        $this->fillinForm('userid', $user);
        $this->fillinForm('password', $password);
        $this->submitForm();
        $this->seePasswordUsernameNotMatch();
    }

    /**
     * @dataProvider providerRegisterWrong
     * @param string $user
     * @param string $firstname
     * @param string $lastname
     * @param string $password
     * @param string $password_repead
     * @param string $mail
     * @param array $errors
     */
    public function testRegisterWrong($user, $firstname, $lastname, $password, $password_repead, $mail, $errors)
    {
        $this->visitRegister();
        $this->fillinForm('userid', $user);
        $this->fillinForm('firstname', $firstname);
        $this->fillinForm('lastname', $lastname);
        $this->fillinForm('password', $password);
        $this->fillinForm('password_repead', $password_repead);
        $this->fillinForm('mail', $mail);
        $this->submitForm();
        foreach ($errors as $error)
            $this->seeErrorOn($error);
    }

    /**
     * @dataProvider providerRegister
     * @param stirng $user
     * @param stirng $firstname
     * @param stirng $lastname
     * @param stirng $password
     * @param stirng $password_repead
     * @param stirng $mail
     */
    public function testRegister($user, $firstname, $lastname, $password, $password_repead, $mail)
    {
        $this->visitRegister();
        $this->fillinForm('userid', $user);
        $this->fillinForm('firstname', $firstname);
        $this->fillinForm('lastname', $lastname);
        $this->fillinForm('password', $password);
        $this->fillinForm('password_repead', $password_repead);
        $this->fillinForm('mail', $mail);
        $this->submitForm();
        $this->seeSuccessOnRegister();
    }

    /**
     * @dataProvider providerLogin
     * @param string $user
     * @param string $password
     */
    public function testLogin($user, $password)
    {
        $this->visitLogin();
        $this->fillinForm('userid', $user);
        $this->fillinForm('password', $password);
        $this->submitForm();
        $this->seeSuccessOnLogin($user);
        $this->logout();
        $this->seeLogout($user);
    }

    /**
     * Visit the LoginForm
     */
    public function visitLogin()
    {
        $this->visitTag('login', array(
            'tag' => 'li',
            'content' => $this->getMessage(MSG::HEAD_LOGIN)
        ));
    }

    /**
     * Visit the RegisterForm
     */
    public function visitRegister()
    {
        $this->visitTag('login/register', array(
            'tag' => 'li',
            'content' => $this->getMessage(MSG::HEAD_REGISTER)
        ));
    }

    /**
     * Submit the Form
     */
    public function submitForm()
    {
        $this->clickAndWait("//button[@type='submit']");
    }

    public function logout($user)
    {
        $this->click("link=$user");
        $this->clickAndWait("link=" . $this->getMessage(MSG::MP_LOGOUT));
    }

    public function seePasswordUsernameNotMatch()
    {
        $matcher = array(
            'tag' => 'div',
            'class' => 'alert-danger',
            'content' => $this->getMessage(MSG::ERROR_LOGIN_PWWRONG),
        );
        $this->assertTag($matcher, $this->getHtmlSource());
    }

    public function seeSuccessOnLogin($user)
    {
        $this->assertTextPresent($user);
    }

    public function seeSuccessOnRegister()
    {
        $this->assertTextPresent($this->getMessage(MSG::SUCCESS_LOGIN_REGISTER));
    }

    public function seeLogout($user)
    {
        $this->assertTextNotPresent($user);
    }

    public function providerLoginWrong()
    {
        return array(
            array('bod', 'testPW123'),
            array('asdf', 'password'),
            array('343askldf', 'trylogin'),
            array('admin', 'admin'),
        );
    }

    public function providerRegisterWrong()
    {
        return array(
            array('nothing', 'nothing', 'nothing', 'nothing', 'nothing',
                'nothing', array('userid', 'firstname', 'lastname', 'password',
                    'password_repead', 'mail')),
            array('bob123', 'nothing', 'nothing', 'nothing', 'nothing',
                'nothing', array('firstname', 'lastname', 'password', 'password_repead',
                    'mail')),
            array('nothing', 'Bob', 'nothing', 'nothing', 'nothing', 'nothing',
                array('userid', 'lastname', 'password', 'password_repead',
                    'mail')),
            array('nothing', 'nothing', 'Diedeldumm', 'nothing', 'nothing',
                'nothing', array('userid', 'firstname', 'password', 'password_repead',
                    'mail')),
            array('nothing', 'nothing', 'nothing', 'test', 'nothing', 'nothing',
                array('userid', 'firstname', 'lastname', 'password', 'password_repead',
                    'mail')),
            array('nothing', 'nothing', 'nothing', 'test123', 'nothing',
                'nothing', array('userid', 'firstname', 'lastname', 'password',
                    'password_repead', 'mail')),
            array('nothing', 'nothing', 'nothing', 'Test', 'nothing', 'nothing',
                array('userid', 'firstname', 'lastname', 'password', 'password_repead',
                    'mail')),
            array('nothing', 'nothing', 'nothing', 'Test1234', 'nothing',
                'nothing', array('userid', 'firstname', 'lastname', 'password_repead',
                    'mail')),
            array('nothing', 'nothing', 'nothing', 'nothing', 'Test1234',
                'nothing', array('userid', 'firstname', 'lastname', 'password',
                    'password_repead', 'mail')),
            array('nothing', 'nothing', 'nothing', 'Test1234', 'Test1234',
                'nothing', array('userid', 'firstname', 'lastname', 'mail')),
            array('nothing', 'nothing', 'nothing', 'nothing', 'nothing',
                'bob.bob@domain.de', array('userid', 'firstname', 'lastname',
                    'password', 'password_repead')),
        );
    }

    public function providerRegister()
    {
        return array(
            array('bobtest', 'Bob', 'Diedeldumm', 'TestPW1234', 'TestPW1234',
                'bot.bob@domain.de'),
        );
    }

    public function providerLogin()
    {
        return array(
            array('bobtest', 'TestPW1234'),
        );
    }

    public function providerLogout()
    {
        return array(
            array('bobtest'),
        );
    }

}
