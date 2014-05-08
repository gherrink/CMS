<?php

/**
 * This is the model class for table "GalleryView".
 *
 * The followings are the available columns in table 'GalleryView':
 * @property string $galleryid
 * @property string $languageid
 * @property string $label
 * @property string $roleaccess
 * @property string $head
 * @property string $imageid
 * @property string $url
 * @property string $parent_galleryid
 * @property string $parent_label
 * @property string $create_userid
 * @property string $create_time
 * @property string $update_userid
 * @property string $update_time
 */
class GalleryView extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'GalleryView';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('languageid', 'required'),
			array('galleryid, imageid, parent_galleryid', 'length', 'max'=>32),
			array('languageid', 'length', 'max'=>2),
			array('label, parent_label, create_userid, update_userid', 'length', 'max'=>20),
			array('roleaccess', 'length', 'max'=>64),
			array('head', 'length', 'max'=>40),
			array('url', 'length', 'max'=>50),
			array('create_time, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('galleryid, languageid, label, roleaccess, head, imageid, url, parent_galleryid, parent_label, create_userid, create_time, update_userid, update_time', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'galleryid' => 'Galleryid',
			'languageid' => 'Languageid',
			'label' => 'Label',
			'roleaccess' => 'Roleaccess',
			'head' => 'Head',
			'imageid' => 'Imageid',
			'url' => 'Url',
			'parent_galleryid' => 'Parent Galleryid',
			'parent_label' => 'Parent Label',
			'create_userid' => 'Create Userid',
			'create_time' => 'Create Time',
			'update_userid' => 'Update Userid',
			'update_time' => 'Update Time',
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
		$criteria->compare('languageid',$this->languageid,true);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('roleaccess',$this->roleaccess,true);
		$criteria->compare('head',$this->head,true);
		$criteria->compare('imageid',$this->imageid,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('parent_galleryid',$this->parent_galleryid,true);
		$criteria->compare('parent_label',$this->parent_label,true);
		$criteria->compare('create_userid',$this->create_userid,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_userid',$this->update_userid,true);
		$criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GalleryView the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
