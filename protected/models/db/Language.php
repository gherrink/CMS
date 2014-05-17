<?php

/**
 * This is the model class for table "Language".
 *
 * The followings are the available columns in table 'Language':
 * @property string $languageid
 * @property string $label
 * @property integer $active
 * @property string $flag
 *
 * The followings are the available model relations:
 * @property Menu[] $menus
 */
class Language extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Language';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('languageid, label, flag', 'required'),
			array('active', 'numerical', 'integerOnly'=>true),
			array('langugage_id', 'length', 'max'=>2),
			array('label', 'length', 'max'=>20),
			array('flag', 'length', 'max'=>50),
			array('langugage_id, label, active, flag', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'menus' => array(self::HAS_MANY, 'Menu', 'languageid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'languageid' => 'Langugage',
			'label' => 'Label',
			'active' => 'Active',
			'flag' => 'Flag',
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
		$criteria=new CDbCriteria;

		$criteria->compare('languageid',$this->languageid,true);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('flag',$this->flag,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DBLanguage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * Prüft ob die Sprache aktive ist.
	 * @param String $language
	 */
	public static function isLanguageActive($language)
	{
		$language = Language::model()->findByAttributes(array('languageid'=>$language));
		return ($language !== null);
	}
    
    /**
	 * gives an Array of all active languages
	 * @return string[]
	 */
	public static function getActiveLanguages()
	{
		$languages = Language::model()->findAllByAttributes(array('active'=>1));
		$return = array();
		foreach ($languages as $language)
			$return[$language->languageid] = MsgPicker::msg()->getMessage(strtoupper($language->languageid));
		
		return $return;
	}
}
