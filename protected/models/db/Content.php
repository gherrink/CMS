<?php

/**
 * This is the model class for table "Content".
 *
 * The followings are the available columns in table 'Content':
 * @property string $contentid
 * @property string $label
 * @property string $text
 * @property string $languageid
 * @property string $roleaccess
 * @property string $update_time
 * @property string $update_userid
 * @property string $create_time
 * @property string $create_userid
 *
 * The followings are the available model relations:
 * @property Language $language
 * @property AuthItem $roleaccess0
 * @property User $createUser
 * @property User $updateUser
 * @property SiteContent[] $siteContents
 */
class Content extends CActiveRecord
{
	public $oldLabel;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Content';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('label, languageid, roleaccess', 'required', 'on'=>'create, update'),
			array('contentid', 'length', 'max'=>32),
			array('label, update_userid, create_userid', 'length', 'max'=>20),
			array('languageid', 'length', 'max'=>2),
			array('roleaccess', 'length', 'max'=>64),
			array('label', 'match', 'pattern'=>'/^[A-Za-z]+$/u',
					'message'=>MsgPicker::msg()->getMessage(MSG::SITE_MSG_MATCH)),
			array('label', 'unique', 'on'=>'create'),
			array('label', 'testLabel', 'on'=>'update'),
			array('oldLabel', 'safe', 'on'=>'update'),
			array('contentid, label, text, languageid, roleaccess, update_time, update_userid, create_time, create_userid', 'safe', 'on'=>'search'),
		);
	}
	
	public function testLabel($attribute, $params)
	{
		if($this->oldLabel === $this->label)
			return true;
	
		$content = Content::model()->findByAttributes(array('label'=>$this->label));
		if($content !== null)
			$this->addError($attribute, MsgPicker::msg()->getMessage(MSG::SITE_MSG_LABELEXISTS));
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'language' => array(self::BELONGS_TO, 'Language', 'languageid'),
			'roleaccess0' => array(self::BELONGS_TO, 'AuthItem', 'roleaccess'),
			'createUser' => array(self::BELONGS_TO, 'User', 'create_userid'),
			'updateUser' => array(self::BELONGS_TO, 'User', 'update_userid'),
			'siteContents' => array(self::HAS_MANY, 'SiteContent', 'contentid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'label' 		=> MsgPicker::msg()->getMessage(MSG::MODEL_LABEL),
			'languageid' 	=> MsgPicker::msg()->getMessage(MSG::MODEL_LANGUAGE),
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

		$criteria->compare('contentid',$this->contentid,true);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('languageid',$this->languageid,true);
		$criteria->compare('roleaccess',$this->roleaccess,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('update_userid',$this->update_userid,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('create_userid',$this->create_userid,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Content the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
