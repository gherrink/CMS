<?php

/**
 * This is the model class for table "GalleryLanguage".
 *
 * The followings are the available columns in table 'GalleryLanguage':
 * @property string $galleryid
 * @property string $languageid
 * @property string $head
 */
class GalleryLanguage extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'GalleryLanguage';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('galleryid, languageid, head', 'required'),
			array('galleryid', 'length', 'max'=>32),
			array('languageid', 'length', 'max'=>2),
			array('head', 'length', 'max'=>40),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('galleryid, languageid, head', 'safe', 'on'=>'search'),
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
			'head' => MsgPicker::msg()->getMessage(MSG::GAL_TITLE),
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
		$criteria->compare('head',$this->head,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GalleryLanguage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
