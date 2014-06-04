<?php
/*
 * Copyright (C) 2014 Maurice Busch <busch.maurice@gmx.net>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * The LayoutManager manages the available Layouts
 *
 * @author Maurice Busch <busch.maurice@gmx.net>
 */
class DbAuthManager extends CDbAuthManager
{
	/**
	 * Erstellt aus einer AuthItem liste ein Rollen Array.
	 * @param unknown $roles
	 * @return Ambigous <Ambigous, string, mixed, multitype:>
	 */
	private static function buildRolesArray($roles)
	{
		while ( ($role = current($roles)) !== FALSE ) {
 			$return[key($roles)] = MSG::msg()->getMsg(key($roles));
			next($roles);
		}
		return $return;
	}
	
    /**
     * returns an array of all available roles
     * @return string[]
     */
	public function getAllRoles()
	{
		return $this->buildRolesArray($this->getRoles());
	}
    
    /**
     * Gives an array with the roles witch are needed everywhere
     * @return string[]
     */
    private static function getUserRoles()
	{
		return array(
			MSG::MEMBER => MsgPicker::msg()->getMessage(MSG::MEMBER),
			MSG::USER => MsgPicker::msg()->getMessage(MSG::USER),
			MSG::VISITOR => MsgPicker::msg()->getMessage(MSG::VISITOR),
		);
	}
	
	/**
	 * Alle Rollen die für die Seiten benötigt werden
	 * @return string[]
	 */
	public static function getRolesSite()
	{
		return CMap::mergeArray(array(
			MSG::MSITE => MsgPicker::msg()->getMessage(MSG::MSITE),
		), self::getUserRoles());
	}
	
	/**
	 * Alle Rollen die für das Menü benötigt werden
	 * @return string[]
	 */
	public static function getRolesMenu()
	{
		return CMap::mergeArray(array(
				MSG::MMENU => MsgPicker::msg()->getMessage(MSG::MMENU),
		), self::getUserRoles());
	}
	
	/**
	 * Alle Rollen die für die Gallery benötigt werden
	 * @return string[]
	 */
	public static function getRolesGallery()
	{
		return CMap::mergeArray(array(
				MSG::MGALLERY => MsgPicker::msg()->getMessage(MSG::MGALLERY),
		), self::getUserRoles());
	}
    
    /**
	 * Alle Rollen die für die Gallery benötigt werden
	 * @return string[]
	 */
	public static function getRolesNews()
	{
		return CMap::mergeArray(array(
				MSG::MNEWS => MsgPicker::msg()->getMessage(MSG::MNEWS),
		), self::getUserRoles());
	}
	
	/**
	 * Gibt die Default Rolle für die Seiten zurück.
	 * @return string
	 */
	public static function getDefaultSiteRole()
	{
		return MSG::MSITE;
	}
	
	/**
	 * Gibt die Default Rolle für das Menü zurück.
	 * @return string
	 */
	public static function getDefaultMenuRole()
	{
		return MSG::MMENU;
	}
	
	/**
	 * Gibt die Default Rolle für die News zurück.
	 * @return string
	 */
	public static function getDefaultNewsRole()
	{
		return MSG::MNEWS;
	}
	
	/**
	 * Gibt die Default Rolle für die Gallerie zurück.
	 * @return string
	 */
	public static function getDefaultGalleryRole()
	{
		return MSG::MGALLERY;
	}
}