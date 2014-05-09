<?php

/**
 * This is the model class for table "SiteContent".
 *
 * The followings are the available columns in table 'SiteContent':
 * @property string $siteid
 * @property string $contentid
 * @property integer $col
 * @property integer $position
 *
 * The followings are the available model relations:
 * @property SiteLanguage $site
 * @property SiteLanguage $language
 * @property Content $content
 */
class SiteContent extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'SiteContent';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('siteid, contentid, col, position', 'required'),
			array('col, position', 'numerical', 'integerOnly'=>true),
			array('siteid, contentid', 'length', 'max'=>32),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('siteid, contentid, col, position', 'safe', 'on'=>'search'),
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
			'site' => array(self::HAS_ONE, 'Site', 'siteid'),
			'content' => array(self::BELONGS_TO, 'Content', 'contentid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'siteid' => 'Siteid',
			'contentid' => 'Contentid',
			'col' => 'Col',
			'position' => 'Position',
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
		$criteria->compare('contentid',$this->contentid,true);
		$criteria->compare('col',$this->col);
		$criteria->compare('position',$this->position);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SiteContent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * 
	 * @param unknown $siteid
	 * @return Ambigous <string, mixed, unknown>
	 */
	public static function getLastPosition($siteid, $col = 1)
	{
		return SiteContent::model()->count("siteid = '$siteid' AND col = $col");
	}
}
