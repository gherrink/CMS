<?php

/**
 * This is the model class for table "SiteLanguage".
 *
 * The followings are the available columns in table 'SiteLanguage':
 * @property string $siteid
 * @property string $languageid
 * @property string $head
 *
 * The followings are the available model relations:
 * @property SiteContent[] $siteContents
 * @property SiteContent[] $siteContents1
 * @property VisitSite[] $visitSites
 * @property VisitSite[] $visitSites1
 */
class SiteLanguage extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'SiteLanguage';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('siteid, languageid', 'required'),
			array('siteid', 'length', 'max'=>32),
			array('languageid', 'length', 'max'=>2),
			array('head', 'length', 'max'=>40),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('siteid, languageid, head', 'safe', 'on'=>'search'),
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
			'siteContents' => array(self::HAS_MANY, 'SiteContent', 'siteid'),
			'siteContents1' => array(self::HAS_MANY, 'SiteContent', 'languageid'),
			'visitSites' => array(self::HAS_MANY, 'VisitSite', 'siteid'),
			'visitSites1' => array(self::HAS_MANY, 'VisitSite', 'languageid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'siteid' => 'Siteid',
			'languageid' => 'Languageid',
			'head' => 'Head',
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

		$criteria->compare('siteid',$this->siteid,true);
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
	 * @return SiteLanguage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
