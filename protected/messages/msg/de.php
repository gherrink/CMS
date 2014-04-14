<?php
/**
 * @author Maurice Busch
 * Language Array Deutsch
 */

return array(
	'ERROR_MSG_NOT_FOUND'=>'Die Message ###msg### wurde nicht gefunden.',
		
	/* MSG HEADER */
	'MSG_SUCCESS'	=> 'Erfolg',
	'MSG_INFO'		=> 'Information',
	'MSG_WARNING'	=> 'Warnung',
	'MSG_DANGER'	=> 'Error',
	/*/MSG HEADER */
		
	/* Rollen */
	'ADMIN' 	=> 'Administrator',
	'MCALENDER' => 'Modarator Kalender',
	'MGALLERY'	=> 'Moderator Gallery',
	'MSITE'		=> 'Moderator Seite',
	'MMENU'		=> 'Moderator Menü',
	'MNEWS'		=> 'Moderator News',
	'MEMBER'	=> 'Mitglied',
	'USER'		=> 'Benutzer',
	'VISITOR'	=> 'Besucher',
	/*/Rollen */
		
	/* Menu Punkte */
	'MP_LOGIN'					=> 'Anmelden',
	'MP_LOGOUT'					=> 'Abmelden',
	'MP_CONTACT'				=> 'Kontakt',
	'MP_USER_REGISTERASMEMBER'	=> 'Mitgliedsregistrierung',
	/*/Menu Punkte */
		
	/* Ueberschriften */
	'HEAD_CONTACT'		=> 'Kontakt',
	'HEAD_LOGIN'		=> 'Anmelden',
	'HEAD_REGISTER'		=> 'Registrieren',
	'HEAD_CHANGEMAIL'	=> 'E-Mail ändern',
	/*/Ueberschriften */
		
	/* Buttons */
	'BTN_OK'		=> 'OK',
	'BTN_REGISTER'	=> 'Registrieren',
	/*/Buttons */
		
	/* Contact */
	'CONTACT_INFO'		=> 'Wenn Sie fragen oder Anmerkungen haben, f&uuml;llen Sie bitte das folgende Formular aus, um uns zu kontaktieren. Wir danken f&uuml;r Ihre Angaschma.',
	'CONTACT_NAME'		=> 'Name',
	'CONTACT_MAIL'		=> 'Mail',
	'CONTACT_SUBJECT'	=> 'Betreff',
	'CONTACT_BODY'		=> 'Text',
	/*/Contact */

	/* User */
	'USER_USER'			=> 'Benutzername',
	'USER_FIRSTNAME'	=> 'Vorname',
	'USER_LASTNAME'		=> 'Nachname',
	'USER_PASSWORD'		=> 'Passwort',
	'USER_PASSWORDREP'	=> 'Passwort wiederholen',
	'USER_MAIL'			=> 'Mail',
	'USER_MSG_USER'		=> 'Der Benutzername darf nur aus Zahlen, Groß- und Kleinbuchstaben und "-_".',
	'USER_MSG_PASSWORD'	=> 'Das Passwort muss aus mindestens einer Zahl, einem Groß- und einem Kleinbuchstaben bestehen.',
	/*/User */

	/* Site */

	/*/Site */

	/* MSG SUCCESS */
	'SUCCESS_CONTACT_SENDMAIL'		=> 'Ihre Kontaktmail wurde erfolgreich versendet, wir werden Ihre Anfrage sobald wie möglich bearbeiten.',
	'SUCCESS_LOGIN_REGISTER'		=> 'Sie wurden erfolgreich registriert, bitte Prüben Sie ihr E-Mail Postfach.',
	'SUCCESS_LOGIN_USERVALIDATE'	=> 'Ihre E-Mail wurde erfolgreich registriert, Sie können sich nun anmelden.',
	'SUCCESS_LOGIN_RESENDMAIL'		=> 'Die Registrierungsmail wurde erneut an ihre E-Mail-Addresse gesendet, bitte prüfen Sie ihr Postfach.',
	'SUCCESS_LOGIN_MAILCHANGE'		=> 'Ihre E-Mail-Addresse wurde erfolgreich geändert und eine Registrierungsmail gesendet. Bitte prüfen Sie die Mails in ihrem Postfach.',
	/*/MSG SUCCESS */

	/* MSG WARNING */
	'WARNING_LOGIN_MAILNOTVALID'		=> 'Ihre Mailadresse wurde noch nicht best&auml;tigt.<br>
											<a href="###mailresend###">E-Mail erneut senden</a> <br>
											<a href="###mailchange###">E-Mail &auml;ndern</a>',
	'WARNING_LOGIN_SENDREGISTERMAIL'	=> 'Sie wurden erfolgreich angemeldet, aber die Registrierungsemail konnte nicht gesendet werden. Bitte versuchen Sie sich anzumelden, dann werden Sie aufgefordert ihre Mailaddresse zu ändern oder die Mail erneut zu senden.',
	/*/MSG WARNING */
	
	/* MSG ERROR */
	'ERROR_CONTACT_SENDMAIL'		=> 'Ihre Kontakt-Email wurde leider nicht gesendet, bitte versuchen Sie es später erneut.',
	'ERROR_LOGIN_PWWRONG'			=> 'Der Benutzername und das Passwort passen nicht zusammen.',
	'ERROR_LOGIN_NOTREGISTERED'		=> 'Bei der Registrierung ist ein Fehler aufgetreten, bitte versuchen Sie es erneut.',
	'ERROR_LOGIN_USERVALIDATE'		=> 'Ihre E-Mail-Addresse konnte leider nicht validiert werden, bitte versuchen Sie es erneut, oder <a href="###mailchange###">&auml;ndern Sie ihre E-Mail</a>',
	'ERROR_LOGIN_RESENDMAIL'		=> 'Die Registrierungsmail konnte leider nicht versendet werden, bitte versuchen Sie es erneut.',
	'ERROR_LOGIN_MAILCHANGE'		=> 'Ihre E-Mail-Addresse konnte leider nicht geändert werden, bitte versuchen Sie es erneut.',
	/*/MSG ERROR */

	/* EXEPTION */
	'EXEPTION_SITE_NOTFOUND' 	=> 'Die Angeforderte Seite konnte leider nicht gefunden werden.',
	'EXEPTION_SITE_NOCONTENT'	=> 'Die Seite hat noch keinen Inhalt',
	/*/EXEPTION */
		
	/* MAIL */
	'MAIL_SUBJECT_REGISTER' => 'E-Mail Best&auml;tigung bei CMS',
	'MAIL_BODY_REGISTER'	=> '<p>Hallo ###name###,</p>
		<p>um Ihre Registierung auf CMS abzuschlie&szlig;en klicken Sie bitte auf folgenden Link: </p>
		<p><a href="###link###">E-Mail best&auml;tigen.</a></p>
		<p>Mit freundlichen Gr&szling;en</p>
		<p>Ihr CMS-Team</p>',
	/*/MAIL */
	
	'VERIFY'			=> 'Verifizierungscode',
	'VERIFY_INFO'		=> 'Bitte tragen Sie die Buchstaben so ein, wie sie im Bild dar&uuml;ber zu sehen sind.
					<br/>Gro&szlig;- und Kleinschreibung muss nicht beachtet werden.',
	
	'CREATE_USER_TIME' => 'Erstellt von ###user### am ###time###',
	'UPDATE_USER_TIME' => 'Geändert von ###user### am ###time###',				
	
	'FOOTER' => 'Copyright &copy; ###year### bei CollectMySociety.<br/>
		Alle Rechte Vorbehalten.</br>
		Entwickelt von Maurice Busch.</br>',
	'MSG_TEST' => 'Das ist ein Test',
);