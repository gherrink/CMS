<?php

/**
 * This is the model class for table "Visit".
 *
 * The followings are the available columns in table 'Visit':
 * @property string $visitid
 * @property string $session
 * @property string $ip
 * @property string $system
 * @property string $browser
 * @property string $version
 *
 * The followings are the available model relations:
 * @property VisitSite[] $visitSites
 * @property User[] $users
 */
class Visit extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Visit';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('visitid, session, ip, system, browser, version', 'required'),
			array('visitid, session', 'length', 'max'=>32),
			array('ip', 'length', 'max'=>15),
			array('system, browser', 'length', 'max'=>3),
			array('version', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('visitid, session, ip, system, browser, version', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'visitSites' => array(self::HAS_MANY, 'VisitSite', 'visitid'),
			'users' => array(self::MANY_MANY, 'User', 'VisitUser(visitid, userid)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'visitid' => 'Visitid',
			'session' => 'Session',
			'ip' => 'Ip',
			'system' => 'System',
			'browser' => 'Browser',
			'version' => 'Version',
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

		$criteria=new CDbCriteria;

		$criteria->compare('visitid',$this->visitid,true);
		$criteria->compare('session',$this->session,true);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('system',$this->system,true);
		$criteria->compare('browser',$this->browser,true);
		$criteria->compare('version',$this->version,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Visit the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
