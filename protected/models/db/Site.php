<?php

/**
 * This is the model class for table "Site".
 *
 * The followings are the available columns in table 'Site':
 * @property string $siteid
 * @property string $label
 * @property string $layout
 * @property string $roleaccess
 * @property string $update_time
 * @property string $update_userid
 * @property string $create_time
 * @property string $create_userid
 *
 * The followings are the available model relations:
 * @property User $updateUser
 * @property AuthItem $roleaccess0
 * @property User $createUser
 * @property Language[] $languages
 */
class Site extends CActiveRecord
{
	public $oldLabel;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Site';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('label, layout, roleaccess', 'required', 'on'=>'create, update'),
			array('siteid', 'length', 'max'=>32),
			array('label, update_userid, create_userid', 'length', 'max'=>20),
			array('layout', 'length', 'max'=>5),
			array('roleaccess', 'length', 'max'=>64),
			array('label', 'match', 'pattern'=>'/^[A-Za-z]+$/u',
					'message'=>MsgPicker::msg()->getMessage(MSG::SITE_MSG_MATCH)),
			array('label', 'unique', 'on'=>'create'),
			array('label', 'testLabel', 'on'=>'update'),
			array('oldLabel', 'safe', 'on'=>'update'),
			array('label, layout, roleaccess', 'safe', 'on'=>'search'),
		);
	}
	
	public function testLabel($attribute, $params)
	{
		if($this->oldLabel === $this->label)
			return true;
		
		$site = Site::model()->findByAttributes(array('label'=>$this->label));
		if($site !== null)
			$this->addError($attribute, MsgPicker::msg()->getMessage(MSG::SITE_MSG_LABELEXISTS));
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'updateUser' => array(self::BELONGS_TO, 'User', 'update_userid'),
			'roleaccess0' => array(self::BELONGS_TO, 'AuthItem', 'roleaccess'),
			'createUser' => array(self::BELONGS_TO, 'User', 'create_userid'),
			'languages' => array(self::MANY_MANY, 'Language', 'SiteLanguage(siteid, languageid)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'label' 		=> MsgPicker::msg()->getMessage(MSG::MODEL_LABEL),
			'layout' 		=> MsgPicker::msg()->getMessage(MSG::SITE_LAYOUT),
			'roleaccess' 	=> MsgPicker::msg()->getMessage(MSG::MODEL_ROLE),
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

		$criteria->compare('label',$this->label,true);
		$criteria->compare('layout',$this->layout,true);
		$criteria->compare('roleaccess',$this->roleaccess,true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Site the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
