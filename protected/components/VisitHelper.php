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
 * Description of VisitHelper
 *
 * @author Maurice Busch <busch.maurice@gmx.net>
 */
class VisitHelper
{
    
    public static function siteVisit($siteID)
	{
		$visitID = self::getVisit();
		if(! $visitID)
			return false;
		$siteVisit = new VisitSite();
		$siteVisit->siteid = $siteID;
		$siteVisit->visitid = $visitID;
		$siteVisit->languageid = Yii::app()->language;
		return $siteVisit->insert();
		/**
		 * @todo Wenn jemand die Seite aktualisiert wird diese Aktualisierung
		 * ebenfalls geloggt. Wenn noch die Zeitspanne mit überprüft wird, kann
		 * das verhindert werden.
		 */
	}
	
	public static function userLogin($userID)
	{
		$visitID = self::getVisit();
		if(! $visitID)
			return false;
        $vist = new VisitUser();
		$vist->userid = $userID;
		$vist->visitid = $visitID;
		return $vist->insert();
	}
    
    private static function getVisit()
	{
		$ip = ClientInfo::getIP();
		$session = Yii::app()->session->getSessionID();
		$visit = Visit::model()->findByAttributes(array('session'=>$session, 'ip'=>$ip));
		if($visit === null)
		{
			$visit = new Visit();
			$visit->visitid = Yii::app()->keygen->getUniquKey();
            $visit->session = $session;
			$visit->ip = $ip;
			$browser = ClientInfo::getBrowser();
			$visit->browser = $browser['name'];
			$visit->version = $browser['version'];
			$visit->system = $browser['platform'];
			
			if(! $visit->insert() && ! $visit->refresh())
				return false;
		}
		return $visit->visitid;
	}
}
