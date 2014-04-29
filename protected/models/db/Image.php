<?php

/**
 * This is the model class for table "Image".
 *
 * The followings are the available columns in table 'Image':
 * @property string $imageid
 * @property string $url
 * @property string $roleaccess
 * @property string $update_userid
 * @property string $update_time
 * @property string $create_userid
 * @property string $create_time
 *
 * The followings are the available model relations:
 * @property Gallery[] $galleries
 * @property GalleryImage[] $galleryImages
 * @property User $createUser
 * @property AuthItem $roleaccess0
 * @property User $updateUser
 * @property Language[] $languages
 */
class Image extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Image';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('imageid, url, roleaccess, update_userid, update_time, create_userid', 'required'),
			array('imageid', 'length', 'max'=>32),
			array('url', 'length', 'max'=>50),
			array('roleaccess', 'length', 'max'=>64),
			array('update_userid, create_userid', 'length', 'max'=>20),
			array('create_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('imageid, url, roleaccess, update_userid, update_time, create_userid, create_time', 'safe', 'on'=>'search'),
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
			'galleries' => array(self::HAS_MANY, 'Gallery', 'imageid'),
			'galleryImages' => array(self::HAS_MANY, 'GalleryImage', 'imageid'),
			'createUser' => array(self::BELONGS_TO, 'User', 'create_userid'),
			'roleaccess0' => array(self::BELONGS_TO, 'AuthItem', 'roleaccess'),
			'updateUser' => array(self::BELONGS_TO, 'User', 'update_userid'),
			'languages' => array(self::MANY_MANY, 'Language', 'ImageLanguage(imageid, languageid)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'imageid' => 'Imageid',
			'url' => 'Url',
			'roleaccess' => 'Roleaccess',
			'update_userid' => 'Update Userid',
			'update_time' => 'Update Time',
			'create_userid' => 'Create Userid',
			'create_time' => 'Create Time',
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

		$criteria->compare('imageid',$this->imageid,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('roleaccess',$this->roleaccess,true);
		$criteria->compare('update_userid',$this->update_userid,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_userid',$this->create_userid,true);
		$criteria->compare('create_time',$this->create_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Image the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
