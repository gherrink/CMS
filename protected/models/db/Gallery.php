<?php

/**
 * This is the model class for table "Gallery".
 *
 * The followings are the available columns in table 'Gallery':
 * @property string $galleryid
 * @property string $label
 * @property string $imageid
 * @property string $parent_galleryid
 * @property string $roleaccess
 * @property string $update_userid
 * @property string $update_time
 * @property string $create_userid
 * @property string $create_time
 *
 * The followings are the available model relations:
 * @property Image $image
 * @property AuthItem $roleaccess0
 * @property User $updateUser
 * @property User $createUser
 * @property Gallery $parentGallery
 * @property Gallery[] $galleries
 * @property GalleryImage[] $galleryImages
 * @property Language[] $languages
 */
class Gallery extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Gallery';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('galleryid, label, imageid, roleaccess, update_userid, update_time, create_userid', 'required'),
			array('galleryid, imageid, parent_galleryid', 'length', 'max'=>32),
			array('label, update_userid, create_userid', 'length', 'max'=>20),
			array('roleaccess', 'length', 'max'=>64),
			array('create_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('galleryid, label, imageid, parent_galleryid, roleaccess, update_userid, update_time, create_userid, create_time', 'safe', 'on'=>'search'),
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
			'image' => array(self::BELONGS_TO, 'Image', 'imageid'),
			'roleaccess0' => array(self::BELONGS_TO, 'AuthItem', 'roleaccess'),
			'updateUser' => array(self::BELONGS_TO, 'User', 'update_userid'),
			'createUser' => array(self::BELONGS_TO, 'User', 'create_userid'),
			'parentGallery' => array(self::BELONGS_TO, 'Gallery', 'parent_galleryid'),
			'galleries' => array(self::HAS_MANY, 'Gallery', 'parent_galleryid'),
			'galleryImages' => array(self::HAS_MANY, 'GalleryImage', 'galleryid'),
			'languages' => array(self::MANY_MANY, 'Language', 'GalleryLanguage(galleryid, languageid)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'galleryid' => 'Galleryid',
			'label' => 'Label',
			'imageid' => 'Imageid',
			'parent_galleryid' => 'Parent Galleryid',
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

		$criteria->compare('galleryid',$this->galleryid,true);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('imageid',$this->imageid,true);
		$criteria->compare('parent_galleryid',$this->parent_galleryid,true);
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
	 * @return Gallery the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
