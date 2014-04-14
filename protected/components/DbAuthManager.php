<?php
class DbAuthManager extends CDbAuthManager
{
	/**
	 * Erstellt aus einer AuthItem liste ein Rollen Array.
	 * @param unknown $roles
	 * @return Ambigous <Ambigous, string, mixed, multitype:>
	 */
	private function buildRolesArray($roles)
	{
		while ( ($role = current($roles)) !== FALSE ) {
 			$return[key($roles)] = MSG::msg()->getMsg(key($roles));
			next($roles);
		}
		return $return;
	}
	
	public function getRolesArray()
	{
		return $this->buildRolesArray($this->getRoles());
	}
	
	/**
	 * Gibt alle Rollen zurück, die etwas mit Seiten zu tun haben.
	 * @return Ambigous <Ambigous, string, mixed, multitype:>
	 */
	public function getSiteRolesArray()
	{
		return array(
			MSG::MSITE => MSG::msg()->getMsg(MSG::MSITE),
			MSG::MEMBER => MSG::msg()->getMsg(MSG::MEMBER),
			MSG::USER => MSG::msg()->getMsg(MSG::USER),
			MSG::VISITOR => MSG::msg()->getMsg(MSG::VISITOR),
		);
	}
	
	/**
	 * Gibt alle Rollen zurück, die etwas mit dem Menü zu tun haben.
	 * @return Ambigous <Ambigous, string, mixed, multitype:>
	 */
	public function getMenuRolesArray()
	{
		return array(
				MSG::MMENU => MSG::msg()->getMsg(MSG::MMENU),
				MSG::MEMBER => MSG::msg()->getMsg(MSG::MEMBER),
				MSG::USER => MSG::msg()->getMsg(MSG::USER),
				MSG::VISITOR => MSG::msg()->getMsg(MSG::VISITOR),
		);
	}
	
	/**
	 * Gibt alle Rollen zurück, die etwas mit den Neuigkeiten zu tun haben.
	 * @return Ambigous <Ambigous, string, mixed, multitype:>
	 */
	public function getNewsRolesArray()
	{
		return array(
				MSG::MNEWS => MSG::msg()->getMsg(MSG::MNEWS),
				MSG::MEMBER => MSG::msg()->getMsg(MSG::MEMBER),
				MSG::USER => MSG::msg()->getMsg(MSG::USER),
				MSG::VISITOR => MSG::msg()->getMsg(MSG::VISITOR),
		);
	}
	
	/**
	 * Gibt alle Rollen zurück, die etwas mit den Galerien zu tun haben.
	 * @return Ambigous <Ambigous, string, mixed, multitype:>
	 */
	public function getGalleryRolesArray()
	{
		return array(
				MSG::MGALLERY => MSG::msg()->getMsg(MSG::MGALLERY),
				MSG::MEMBER => MSG::msg()->getMsg(MSG::MEMBER),
				MSG::USER => MSG::msg()->getMsg(MSG::USER),
				MSG::VISITOR => MSG::msg()->getMsg(MSG::VISITOR),
		);
	}
	
	/**
	 * Gibt die Defoult Rolle für die Seiten zurück.
	 * @return string
	 */
	public function getDefoultSiteRole()
	{
		return MSG::MSITE;
	}
	
	/**
	 * Gibt die Defoult Rolle für das Menü zurück.
	 * @return string
	 */
	public function getDefoultMenuRole()
	{
		return MSG::MMENU;
	}
	
	/**
	 * Gibt die Defoult Rolle für die News zurück.
	 * @return string
	 */
	public function getDefoultNewsRole()
	{
		return MSG::MNEWS;
	}
	
	/**
	 * Gibt die Defoult Rolle für die Gallerie zurück.
	 * @return string
	 */
	public function getDefoultGalleryRole()
	{
		return MSG::MGALLERY;
	}
}