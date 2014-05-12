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
 * @property string $site
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
 * @property Language $langugage
 * @property User $createUser
 * @property User $updateUser
 * @property Menu $parentMenu
 */
class Menu extends CActiveRecord
{
	public $haschilds;
	public $parent_menu;
	public $oldparent_menuid;
	
	public function init()
	{
		if($this->scenario === 'create')
			$this->url_intern = true;
	}
	
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
		return array(
			array('languageid, label, roleaccess', 'required', 'on'=>'create, update'),
			array('url_intern, position', 'numerical', 'integerOnly'=>true),
			array('menuid, parent_menuid', 'length', 'max'=>32),
			array('site', 'length', 'max'=>20),
			array('languageid, parent_languageid', 'length', 'max'=>2),
			array('label, update_userid, create_userid', 'length', 'max'=>20),
			array('icon', 'length', 'max'=>40),
			array('url', 'length', 'max'=>50),
			array('roleaccess', 'length', 'max'=>64),
			array('haschilds, parent_menu, oldparent_menuid', 'safe', 'on'=>'create, update'),
			array('url', 'validateUrl', 'on'=>'create, update'),
			array('parent_menu', 'validateParent', 'on'=>'create, update'),
			array('menuid, languageid, label, url_intern, url, site, icon, parent_menuid, parent_languageid, update_userid, update_time, create_userid, create_time, roleaccess', 'safe', 'on'=>'search'),
		);
	}
	
	public function validateParent($attribute, $params)
	{
		if($this->parent_menuid === '' || $this->parent_menuid === null)
		{
			$this->parent_languageid = null;
			$this->parent_menuid = null;
		}
		else
		{
			$menu = Menu::model()->findByAttributes(array('menuid'=>$this->parent_menuid, 'languageid'=>$this->parent_languageid));
			if($menu === null)
				throw new CHttpException(500, MsgPicker::msg()->getMessage(MSG::EXCEPTION_MENU_PARENTNOTFOUND));
		}
	}
	
	public function validateUrl($attribute, $params)
	{
		if($this->haschilds)
		{
			$this->url_intern = true;
			$this->site = null;
			$this->url = null;
			
			return true;
		}
		
		if($this->url_intern)
		{
			$site = Site::model()->findByAttributes(array('label'=>$this->url));
			if($site === null)
			{
				$this->addError('url', MsgPicker::msg()->getMessage(MSG::EXCEPTION_SITE_NOTFOUND));
				return false;
			}
			$this->site = $site->label;
			$this->url = null;
			return true;
		}
		
		return true;
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'langugage' => array(self::BELONGS_TO, 'Language', 'languageid'),
			'createUser' => array(self::BELONGS_TO, 'User', 'create_userid'),
			'updateUser' => array(self::BELONGS_TO, 'User', 'update_userid'),
			'parentMenu' => array(self::BELONGS_TO, 'Menu', 'parent_menuid, parent_languageid'),
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
			'site' => 'Site',
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

		$criteria->compare('languageid',$this->languageid,true);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('icon',$this->icon,true);
		$criteria->compare('roleaccess',$this->roleaccess,true);
		$criteria->compare('url_intern',true,true);
		$criteria->addCondition('site IS NULL');
		$criteria->addCondition('url IS NULL');
		
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize' => 8,
				'route'=>'menu/viewUpdate'
			),
			'sort'=>array(
				'route'=>'menu/viewUpdate'
			)
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
	
	public function countOnLevel()
	{
		if($this->parent_menuid === null)
			$where = 'parent_menuid IS NULL AND parent_languageid IS NULL';
		else
			$where = "parent_menuid = '{$this->parent_menuid}' AND parent_languageid = '{$this->parent_languageid}'";
		
		return $this->count($where);
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
				
			if($menu->icon !== null)
			$items[$counter]['icon'] = $menu->icon;
			
			if($menu->url_intern)
			{
				if($menu->site === null && $menu->url === null) //ist ein Menüpunkt
				{
					$items[$counter]['url'] = "#";
					$items[$counter]['items'] = Menu::getMenuItems(Menu::model()->findAll(
							'parent_menuid = "'.$menu->menuid.'" AND languageid = "'.Yii::app()->language.'" ORDER BY position'));
				}
				else //ein interner Link zu einer seite
				{
					$items[$counter]['url'] = Yii::app()->createAbsoluteUrl('site/site', array('name'=>$menu->site));
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
