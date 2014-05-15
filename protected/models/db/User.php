<?php

/**
 * This is the model class for table "User".
 * 
 * @author Maurice Busch
 * 
 * The followings are the available columns in table 'User':
 * @property string $userid
 * @property string $firstname
 * @property string $lastname
 * @property string $password
 * @property string $mail
 * @property integer $mail_valid
 * @property integer $active
 *
 * The followings are the available model relations:
 * @property AuthItem[] $authItems
 * @property Menu[] $menus
 * @property Menu[] $menus1
 * @property UserValidate $validate
 */
class User extends CActiveRecord
{

    public $password_repead;
    public $verifyCode;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'User';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('userid, password', 'required', 'on' => 'login, register, mail'),
            array('mail', 'required', 'on' => 'register, mail'),
            array('password_repead, firstname, lastname', 'required', 'on' => 'register'),
            array('mail_valid, active', 'numerical', 'integerOnly' => true),
            array('userid', 'length', 'min' => 4, 'max' => 20, 'on' => 'register'),
            array('firstname', 'length', 'max' => 20, 'on' => 'register'),
            array('lastname', 'length', 'max' => 30, 'on' => 'register'),
            array('password', 'length', 'min' => 5, 'max' => 64, 'on' => 'register'),
            array('mail', 'length', 'max' => 60, 'on' => 'register, mail'),
            array('userid', 'unique', 'on' => 'register'),
            array('userid', 'match', 'pattern' => '/^[A-Za-z0-9_-]+$/u',
                'message' => MsgPicker::msg()->getMessage(MSG::USER_MSG_USER)),
            array('password', 'match', 'pattern' => '/^.*(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/',
                'message' => MsgPicker::msg()->getMessage(MSG::USER_MSG_PASSWORD),
                'on' => 'register'),
            array('password_repead', 'compare', 'compareAttribute' => 'password',
                'on' => 'register'),
            array('mail', 'email', 'on' => 'register'),
            array('mail', 'unique', 'on' => 'register, mail'),
            array('verifyCode', 'captcha', 'allowEmpty' => (YII_DEBUG || !CCaptcha::checkRequirements()),
                'on' => 'register, mail'),
            array('userid, firstname, lastname, password, mail, mail_valid, active',
                'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'authItems' => array(self::MANY_MANY, 'AuthItem', 'AuthAssignment(userid, itemname)'),
            'menus' => array(self::HAS_MANY, 'Menu', 'create_userid'),
            'menus1' => array(self::HAS_MANY, 'Menu', 'update_userid'),
            'validate' => array(self::HAS_ONE, 'UserValidate', 'userid'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'userid' => MsgPicker::msg()->getMessage(MSG::USER_USER),
            'firstname' => MsgPicker::msg()->getMessage(MSG::USER_FIRSTNAME),
            'lastname' => MsgPicker::msg()->getMessage(MSG::USER_LASTNAME),
            'password' => MsgPicker::msg()->getMessage(MSG::USER_PASSWORD),
            'password_repead' => MsgPicker::msg()->getMessage(MSG::USER_PASSWORDREP),
            'mail' => MsgPicker::msg()->getMessage(MSG::USER_MAIL),
            'verifyCode' => MsgPicker::msg()->getMessage(MSG::VERIFY),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('userid', $this->userid, true);
        $criteria->compare('firstname', $this->firstname, true);
        $criteria->compare('lastname', $this->lastname, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('mail', $this->mail, true);
        $criteria->compare('mail_valid', $this->mail_valid);
        $criteria->compare('active', $this->active);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return DBUser the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}
