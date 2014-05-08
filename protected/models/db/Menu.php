<?php

/**
 * This is the model class for table "Menu".
 *
 * The followings are the available columns in table 'Menu':
 * @property string $menuid
 * @property string $languageid
 * @property string $label
 * @property integer $url_intern
 * @property string $url
 * @property string $siteid
 * @property string $icon
 * @property integer $position
 * @property string $parent_menuid
 * @property string $parent_languageid
 * @property string $update_userid
 * @property string $update_time
 * @property string $create_userid
 * @property string $create_time
 * @property string $roleaccess
 *
 * The followings are the available model relations:
 * @property AuthItem $roleaccess0
 * @property Language $langugage
 * @property User $createUser
 * @property User $updateUser
 * @property DBMenu $parentMenu
 * @property DBMenu[] $menus
 * @property DBMenu $parentLangugage
 * @property DBMenu[] $menus1
 */
class Menu extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Menu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('menuid, languageid, label, url_intern, parent_menuid, parent_languageid, update_userid, update_time, create_userid, roleaccess', 'required'),
			array('url_intern, position', 'numerical', 'integerOnly'=>true),
			array('menuid, siteid, parent_menuid', 'length', 'max'=>32),
			array('languageid, parent_languageid', 'length', 'max'=>2),
			array('label, icon, update_userid, create_userid', 'length', 'max'=>20),
			array('url', 'length', 'max'=>50),
			array('roleaccess', 'length', 'max'=>64),
			array('create_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('menuid, languageid, label, url_intern, url, siteid, icon, parent_menuid, parent_languageid, update_userid, update_time, create_userid, create_time, roleaccess', 'safe', 'on'=>'search'),
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
			'roleaccess0' => array(self::BELONGS_TO, 'AuthItem', 'roleaccess'),
			'langugage' => array(self::BELONGS_TO, 'Language', 'languageid'),
			'createUser' => array(self::BELONGS_TO, 'User', 'create_userid'),
			'updateUser' => array(self::BELONGS_TO, 'User', 'update_userid'),
			'parentMenu' => array(self::BELONGS_TO, 'DBMenu', 'parent_menuid'),
			'menus' => array(self::HAS_MANY, 'DBMenu', 'parent_menuid'),
			'parentLangugage' => array(self::BELONGS_TO, 'DBMenu', 'parent_languageid'),
			'menus1' => array(self::HAS_MANY, 'DBMenu', 'parent_languageid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'menuid' => 'Menuid',
			'languageid' => 'languageid',
			'label' => 'Label',
			'url_intern' => 'Url Intern',
			'url' => 'Url',
			'siteid' => 'Site',
			'icon' => 'Icon',
			'parent_menuid' => 'parent Menuid',
			'parent_languageid' => 'parent languageid',
			'update_userid' => 'Update Userid',
			'update_time' => 'Update Time',
			'create_userid' => 'Create Userid',
			'create_time' => 'Create Time',
			'roleaccess' => 'Roleaccess',
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

		$criteria->compare('menuid',$this->menuid,true);
		$criteria->compare('languageid',$this->languageid,true);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('url_intern',$this->url_intern);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('siteid',$this->siteid,true);
		$criteria->compare('icon',$this->icon,true);
		$criteria->compare('parent_menuid',$this->parent_menuid,true);
		$criteria->compare('parent_languageid',$this->parent_languageid,true);
		$criteria->compare('update_userid',$this->update_userid,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_userid',$this->create_userid,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('roleaccess',$this->roleaccess,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DBMenu the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function getMenuArray()
	{
		return array(
				'collapse' => true,
				'brandLabel' => BsHtml::icon(BsHtml::GLYPHICON_HOME),
				'brandUrl' => Yii::app()->homeUrl,
				'items' => Menu::getMenuItems(Menu::model()->findAll('parent_menuid IS NULL AND languageid = "'.Yii::app()->language.'" ORDER BY position')),
				'menu' => Menu::getMenuNavbar(),
		);
	}
	
	/**
	 * Erstellen des Menüs aus der Datenbank
	 * @param Menus[] $menus
	 */
	private static function getMenuItems($menus)
	{
		$items = array();
		$counter = 0;
		foreach ($menus as $menu)
		{
			$items[$counter]['label'] = $menu->label;
				
			if($menu->url_intern)
			{
				if($menu->siteid === null && $menu->url === null) //ist ein Menüpunkt
				{
					$items[$counter]['url'] = "#";
					$items[$counter]['items'] = Menu::getMenuItems(Menu::model()->findAll(
							'parent_menuid = "'.$menu->menuid.'" AND languageid = "'.Yii::app()->language.'" ORDER BY position'));
				}
				else //ein interner Link zu einer seite
				{
					$items[$counter]['url'] = Yii::app()->createAbsoluteUrl('site/site', array('name'=>$menu->siteid));
				}
			}
			else //externe Url verweist auf eine Seite im WWW
			{
				$items[$counter]['url'] = $menu->url;
			}
				
			$counter++;
		}
		return $items;
	}
	
	/**
	 * Erstellen der Navigationsbar
	 * @return array
	 */
	private static function getMenuNavbar()
	{
		return array(
		// 			getAdmin(),
		// 			getModerator(),
		// 			array(
				// 				'label' => MSG::msg()->getMsg(MSG::MP_GALLERY),
				// 				'url' => array('/gallery/gallery'),
				// 			),	
			
				
			// news Objekt in Leiste von Lukas 28.04
			array(
			'label' => MsgPicker::msg()->getMessage(MSG::MP_NEWS),
			'url' => array('/news'),
			),
			array(
				'label' => MsgPicker::msg()->getMessage(MSG::MP_GALLERY),
				'url' => array('/gallery'),
			),
				
			self::getModerator(),
			array(	
				'label' => MsgPicker::msg()->getMessage(MSG::MP_CONTACT),
				'url' => array('/contact/contact'),
			),
			Menu::getUser(),
		);
	}
	
	/**
	 * Erstellen des Menüpunktes für den User
	 * @return array
	 */
	public static function getUser()
	{
		if(Yii::app()->user->isGuest)
		{
			return array(
					'label' => MsgPicker::msg()->getMessage(MSG::MP_LOGIN),
					'url' => array('/login/login'),
			);
		}
		else
		{
			return array(
					'label' => Yii::app()->user->name,
					'url' => '#',
					'items' => array(
// 							array(
// 									'label' => MsgPicker::msg()->getMessage(MSG::MP_USER_REGISTERASMEMBER),
// 									'url' => Yii::app()->createAbsoluteUrl('/login/registerMember', array('name'=>Yii::app()->user->name)),
// 									'visible' => ! Yii::app()->user->checkAccess(MSG::MEMBER),
// 							),
							array(
									'label' => MsgPicker::msg()->getMessage(MSG::MP_LOGOUT),
									'url' => array('/login/logout'),
							),
					),
			);
		}
	}
	
	/**
	 * Erstllen des Moderator Menüpunktes
	 * @return array
	 */
	public static function getModerator()
	{
		$msite = Yii::app()->user->checkAccess(MSG::MSITE);
		$mmenu = Yii::app()->user->checkAccess(MSG::MMENU);
		
		if($msite || $mmenu)
			return array(
				'label' => MsgPicker::msg()->getMessage(MSG::MP_MODERATOR),
				'url' => '#',
				'items' => array(
					self::getMSite($msite),
					self::getMMenu($mmenu),
				),
					
			);
	}
	
	public static function getMSite($msite)
	{
		if($msite)
			return array(
				'label' => MsgPicker::msg()->getMessage(MSG::MP_MODERATOR_SITE),
				'url' => '#',
				'items' => array(
					array(
						'label' => MsgPicker::msg()->getMessage(MSG::MP_MODERATOR_SITECREATE),
						'ajax' => "cmsShowModalAjax('modal', '".Yii::app()->createAbsoluteUrl('site/create')."');",
					),
					array(
						'label' => MsgPicker::msg()->getMessage(MSG::MP_MODERATOR_CONTENTCREATE),
						'ajax' => "cmsShowModalAjax('modal', '".Yii::app()->createAbsoluteUrl('content/create')."');",
					),
				),
			);
	}
	
	public static function getMMenu($mmneu)
	{
		if($mmneu)
			return array(
				'label' => 'noch machen',
			);
	}
}
