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
 * Description of ClientInfo
 *
 * @author Maurice Busch <busch.maurice@gmx.net>
 */
class ClientInfo
{
    const UNKNOWN = 'UNKNOWN';
	
	/* Plattforms */
	const LINUX = 'linux';
	const MAC = 'mac';
	const WINDOWS = 'windows';
	
	/* Browsers */
	const IE = 'Internet Explorer';
	const MF = 'Mozilla Firefox';
	const GC = 'Google Chrome';
	const SAFARI = 'Apple Safari';
	const OPERA = 'Opera';
	const NETSCAPE = 'Netscape';
	
	/**
	 * Gets the IP form a Client
	 */
	public static function getIP()
	{
		if(isset($_SERVER['HTTP_CLIENT_IP']))
			return $_SERVER['HTTP_CLIENT_IP'];
		
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		
		if(isset($_SERVER['HTTP_X_FORWARDED']))
			return $_SERVER['HTTP_X_FORWARDED'];
		
		if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			return $_SERVER['HTTP_FORWARDED_FOR'];
		
		if(isset($_SERVER['HTTP_FORWARDED']))
			return $_SERVER['HTTP_FORWARDED'];
		
		if(isset($_SERVER['REMOTE_ADDR']))
			return $_SERVER['REMOTE_ADDR'];
		
		return self::UNKNOWN;
	}
	
	private static function getPlatform($u_agent)
	{
		if (preg_match('/linux/i', $u_agent))
			return self::LINUX;
		
		if (preg_match('/macintosh|mac os x/i', $u_agent))
			return self::MAC;
		
		if (preg_match('/windows|win32/i', $u_agent))
			return self::WINDOWS;
		
		return self::UNKNOWN;
	}
	
	public static function getBrowser()
	{
		$u_agent = $_SERVER['HTTP_USER_AGENT'];
		$bname = 'UNKNOWN';
		$version= "";
		
		if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
		{
			$bname = self::IE;
			$ub = "MSIE";
		}
		elseif(preg_match('/Firefox/i',$u_agent))
		{
			$bname = self::MF;
			$ub = "Firefox";
		}
		elseif(preg_match('/Chrome/i',$u_agent))
		{
			$bname = self::GC;
			$ub = "Chrome";
		}
		elseif(preg_match('/Safari/i',$u_agent))
		{
			$bname = self::SAFARI;
			$ub = "Safari";
		}
		elseif(preg_match('/Opera/i',$u_agent))
		{
			$bname = self::OPERA;
			$ub = "Opera";
		}
		elseif(preg_match('/Netscape/i',$u_agent))
		{
			$bname = self::NETSCAPE;
			$ub = "Netscape";
		}
		
		$known = array('Version', $ub, 'other');
		$pattern = '#(?<browser>' . join('|', $known) .')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
		
		if (!preg_match_all($pattern, $u_agent, $matches)){/* no match number */}
		$i = count($matches['browser']);
		
		if ($i != 1) {
			if (strripos($u_agent,"Version") < strripos($u_agent,$ub))
				$version= $matches['version'][0];
			
			else 
				$version= $matches['version'][1];
		}	
		else 
			$version= $matches['version'][0];
		
		if ($version==null || $version=="")
			$version="?";
		
		return array(
			'name' => $bname,
			'version' => $version,
            'platform' => self::getPlatform($u_agent),
		);
	}
}
