<?php

/*
 * Copyright (C) 2014 Maurice Busch <busch.maurice@gmx.net>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Description of MailerTest
 *
 * @author Maurice Busch <busch.maurice@gmx.net>
 */
class MailerTest extends TestCase
{
//    public function __construct($name = NULL, array $data = array(), $dataName = '')
//    {
//        parent::__construct('Mail Test', $data, $dataName);
//    }

    /**
     * @dataProvider providerSendMail
     * @param type $addressee
     * @param type $subject
     * @param type $body
     * @param type $htmlMail
     * @param type $cc
     * @param type $reply
     * @param type $senderMail
     * @param type $senderName
     */
    public function testSendMail($addressee, $subject, $body, $htmlMail, $cc, $reply, $senderMail, $senderName)
    {
        $mail = new Mail($addressee, $subject, $body, $htmlMail);
        $mail->setCc($cc);
        $mail->setReply($reply);
        $mail->setSenderMail($senderMail);
        $mail->setSenderName($senderName);

        $mailer = new Mailer();
        $mailer->sendMail($mail);

        $this->checkMail($mailer, $addressee, $subject, $body, $cc, $reply, $senderMail, $senderName);
    }

    /**
     * @dataProvider providerContactMail
     * @param type $mail
     * @param type $name
     * @param type $subject
     * @param type $body
     */
    public function testContactMail($mail, $name, $subject, $body)
    {
        $contact = new ContactForm;
        $contact->subject = $subject;
        $contact->body = $body;
        $contact->mail = $mail;
        $contact->name = $name;

        $mailer = new Mailer();
        $mailer->sendContactMail($contact);

        $this->checkMail($mailer, $mailer->contactAddress, $subject, $body, '', '', $mail, $name);
    }
    
    /**
     * @dataProvider providerRegisterMail
     * @param type $username
     * @param type $mail
     * @param type $validateid
     */
    public function testRegisterMail($username, $mail, $validateid)
    {
        MsgPicker::msg('de');
        $_SERVER['SERVER_NAME'] = "test";
        $mailer = new Mailer();

        $user = new User();
        $user->userid = $username;
        $user->mail = $mail;
        $validate = new UserValidate();
        $validate->userid = $username;
        $validate->validateid = $validateid;

        $mailer->sendRegisterMail($user, $validate);

        $subject = MsgPicker::msg()->getMessage(MSG::MAIL_SUBJECT_REGISTER);
        $body = MsgPicker::msg()->getMessage(MSG::MAIL_BODY_REGISTER, array(
            'name' => $user->userid,
            'link' => Yii::app()->createAbsoluteUrl('login/userValidate', array(
                'user' => $user->userid, 'key' => $validate->validateid)),
        ));

        $this->checkMail($mailer, $user->mail, $subject, $body, '', '', $mailer->registerMail, $mailer->registerName);
    }

    private function checkMail($mailer, $addressee, $subject, $body, $cc, $reply, $senderMail, $senderName)
    {
        $this->assertArrayHasKey('mail', $GLOBALS, 'Globals array key mail must be set, no mail was send');
        $this->assertArrayHasKey('to', $GLOBALS['mail'], 'Mail was send to nobody, to was not set');
        $this->assertArrayHasKey('subject', $GLOBALS['mail'], 'Mail has no Subject cant be empty');
        $this->assertArrayHasKey('body', $GLOBALS['mail'], 'The Mail body is empty.');
        $this->assertArrayHasKey('header', $GLOBALS['mail'], 'The Mail header is empty.');

        $this->assertStringMatchesFormat($GLOBALS['mail']['to'], $addressee, 'To does not match');
        $this->assertRegExp('*' . base64_encode($subject) . '*', $GLOBALS['mail']['subject'], 'Subject does not match');
        $this->assertStringMatchesFormat($body, $GLOBALS['mail']['body'], 'Body does not match');

        $this->checkHeader($mailer, $senderName, $senderMail, $reply, $cc);
    }

    private function checkHeader($mailer, $senderName, $senderMail, $reply, $cc)
    {
        if ($senderName === '')
            $senderName = $mailer->defaultName;

        $this->assertRegExp('*' . base64_encode($senderName) . '*', $GLOBALS['mail']['header'], 'sender name does not match');

        if ($senderMail === '')
            $senderMail = $mailer->defaultMail;

        $this->assertRegExp('*' . base64_encode($senderName) . '*', $GLOBALS['mail']['header'], 'sender mail does not match');

        if ($reply === '')
            $reply = $senderMail;

        $this->assertRegExp('*' . $reply . '*', $GLOBALS['mail']['header'], 'reply mail does not match');

        if ($cc !== '')
            $this->assertRegExp('*' . $cc . '*', $GLOBALS['mail']['header'], 'cc does not match');
    }

    //$addressee, $subject, $body, $htmlMail, $cc, $reply, $senderMail, $senderName
    public function providerSendMail()
    {
        return array(
            array('dummy.dummy@blla.de', 'A Test Mail', 'Some content for the body.',
                true, '', '', '', ''),
        );
    }

    //$mail, $name, $subject, $body
    public function providerContactMail()
    {
        return array(
            array('bob.depp@gmx.net', 'Bob Depp', 'Kontakt', 'Ein Inhalt'),
        );
    }
    
    //$username, $mail, $validateid
    public function providerRegisterMail()
    {
        return array(
            array('bob', 'bob.depp@gmx.net', 'dkeidheEdh38emc83asd83nd'),
        );
    }

}
