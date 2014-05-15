<?php

/**
 * This Model saves all data for Contacting the Systemadmin.
 * 
 * @author Maurice Busch <busch.maurice@gmx.net>
 * @copyright 2014
 * @version 0.1
 *
 */
class ContactForm extends CFormModel
{

    public $name;
    public $mail;
    public $subject;
    public $body;
    public $verifyCode;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            array('name, mail, subject, body', 'required'),
            array('mail', 'email'),
            array('verifyCode', 'captcha', 'allowEmpty' => (YII_DEBUG || !CCaptcha::checkRequirements())),
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
            'verifyCode' => MsgPicker::msg()->getMessage(MSG::VERIFY),
            'name' => MsgPicker::msg()->getMessage(MSG::CONTACT_NAME),
            'mail' => MsgPicker::msg()->getMessage(MSG::CONTACT_MAIL),
            'subject' => MsgPicker::msg()->getMessage(MSG::CONTACT_SUBJECT),
            'body' => MsgPicker::msg()->getMessage(MSG::CONTACT_BODY),
        );
    }

}
