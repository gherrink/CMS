<?php
/**
 * Erstellen von Arrays für Selects
 * @author Maurice Busch <busch.maurice@gmx.net>
 * @copyright 2014
 * @version 0.1
 *
 */
class SelectHelper
{
	
	/**
	 * Alle Rollen die für die Seitenadministration benötigt werden
	 * @return string[]
	 */
	public static function getSiteRoles()
	{
		return CMap::mergeArray(array(
			MSG::MSITE => MsgPicker::msg()->getMessage(MSG::MSITE),
		), self::getRoles());
	}
	
	/**
	 * Alle Rollen die für die Menüadministration benötigt werden
	 * @return string[]
	 */
	public static function getMenuRoles()
	{
		return CMap::mergeArray(array(
				MSG::MMENU => MsgPicker::msg()->getMessage(MSG::MMENU),
		), self::getRoles());
	}
	
	private static function getRoles()
	{
		return array(
			MSG::MEMBER => MsgPicker::msg()->getMessage(MSG::MEMBER),
			MSG::USER => MsgPicker::msg()->getMessage(MSG::USER),
			MSG::VISITOR => MsgPicker::msg()->getMessage(MSG::VISITOR),
		);
	}
	
	/**
	 * Alle Layouts die es gibt
	 * @return string[]
	 */
	public static function getLayouts()
	{
		return array(
			MSG::COL01 => MsgPicker::msg()->getMessage(MSG::COL01),
		);
	}
	
	/**
	 * Alle aktiven Sprachen
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