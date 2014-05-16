<?php
/**
 * @author Maurice Busch
 * Language Array Deutsch
 */

return array(
	'EXCEPTION_MSG_NOTFOUND'=>'Die Message ###msg### wurde nicht gefunden.',
	
	/* Sprachen */
	'DE'	=> 'German',
	'EN'	=> 'English',
	/*/Sprachen */
	
	/* MSG HEADER */
	'MSG_SUCCESS'	=> 'Success',
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
		
	/* Layouts */
	'COL01'		=> 'Eine Spalte',
	/*/Layouts */
		
	/* Menu Punkte */
	'MP_LOGIN'						=> 'Anmelden',
	'MP_LOGOUT'						=> 'Abmelden',
	'MP_CONTACT'					=> 'Kontakt',
	'MP_USER_REGISTERASMEMBER'		=> 'Mitgliedsregistrierung',
	'MP_NEWS'						=> 'Neuigkeiten',
	'MP_GALLERY'					=> 'Galerie',
	'MP_MODERATOR'					=> 'Moderator',
	'MP_MODERATOR_SITE'				=> 'Seiten',
	'MP_MODERATOR_SITECREATE'		=> 'Seite erstellen',
	'MP_MODERATOR_CONTENTCREATE'	=> 'Inhalt erstellen',
	/*/Menu Punkte */
		
	/* Ueberschriften */
	'HEAD_QUESTION_REALYCLOSE'			=> 'Realy close?',
	'HEAD_QUESTION_REALYDELETE'			=> 'Realy delete?',
	'HEAD_CONTACT'						=> 'Contact',
	'HEAD_LOGIN'						=> 'Login',
	'HEAD_REGISTER'						=> 'Register',
	'HEAD_CHANGEMAIL'					=> 'Change mail',
	'HEAD_SITE_CREATE'					=> 'Create site',
	'HEAD_SITE_UPDATE'					=> 'Edit site',
	'HEAD_SITE_CREATELANGUAGE'			=> 'Languages and Headers',
	'HEAD_CONTENT_CREATE'				=> 'Create Content',
	'HEAD_CONTENT_UPDATE'				=> 'Edit Content',
	'HEAD_CONTENT_ADD2SITE'				=> 'Add content to site',
	'HEAD_NEWS_CREATE'					=> 'Create news',
	'HEAD_NEWS_UPDATE'					=> 'Edit news',
	/*/Ueberschriften */
		
	/* Buttons */
	'BTN_OK'					=> 'OK',
	'BTN_YES'					=> 'Yes',
	'BTN_NO'					=> 'No',
	'BTN_REGISTER'				=> 'Register',
	'BTN_EDIT'					=> 'Edit',
	'BTN_CREATE'				=> 'Create',
	'BTN_UPDATE'				=> 'Update',
	'BTN_DELETE'				=> 'Delete',
	'BTN_EXIT'					=> 'Exit',
	'BTN_NEW_CONTENT'			=> 'Create new Content',
	'BTN_SITE_ADDLANGUAGE'		=> 'Add new Language',
	'BTN_NEWS'					=> 'Add News',
	/*/Buttons */
	
	/* Models */
	'MODEL_LABEL' 		=> 'Identifikation',
	'MODEL_ROLE'		=> 'Zugriffsrechte',
	'MODEL_LANGUAGE'	=> 'Sprache',
	/*/Models */
	
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
	'SITE_LAYOUT'					=> 'Layout',
	'SITE_MSG_MATCH'				=> 'Das Label darf nur Groß- und Kleinbuchstaben enthalten',
	'SITE_MSG_LABELEXISTS'			=> 'Das Label existiert bereits.',
	'SITE_MSG_HEADLANGUAGEEXISTS'	=> 'Für diese Sprache Existiert bereits eine Überschrift, bitte wählen Sie eine andere.',
	/*/Site */

	/* MSG SUCCESS */
	'SUCCESS_CONTACT_SENDMAIL'		=> 'Ihre Kontaktmail wurde erfolgreich versendet, wir werden Ihre Anfrage sobald wie möglich bearbeiten.',
	'SUCCESS_LOGIN_REGISTER'		=> 'Sie wurden erfolgreich registriert, bitte Prüben Sie ihr E-Mail Postfach.',
	'SUCCESS_LOGIN_USERVALIDATE'	=> 'Ihre E-Mail wurde erfolgreich registriert, Sie können sich nun anmelden.',
	'SUCCESS_LOGIN_RESENDMAIL'		=> 'Die Registrierungsmail wurde erneut an ihre E-Mail-Addresse gesendet, bitte prüfen Sie ihr Postfach.',
	'SUCCESS_LOGIN_MAILCHANGE'		=> 'Ihre E-Mail-Addresse wurde erfolgreich geändert und eine Registrierungsmail gesendet. Bitte prüfen Sie die Mails in ihrem Postfach.',
	'SUCCESS_SITE_CREATE'			=> 'Die Seite wurde erfolgreich erstellt.',
	'SUCCESS_SITE_UPDATE'			=> 'Die Seite wurde erfolgreich geändert.',
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
	'ERROR_SITE_NOTCREATE'			=> 'Die Seite konnte nicht erstellt werden, bitte versuchen Sie es erneut.',
	'ERROR_SITE_NOTUPDATE'			=> 'Die Seite konnte nicht geändert werden, bitte versuchen Sie es erneut.',
	'ERROR_CONTENT_NOTCREATE'		=> 'Der Inhalt konnte leider nicht erstellt werden, bitte versuchen Sie es erneut.',
	'ERROR_CONTENT_NOTUPDATE'		=> 'Der Inhalt konnte leider nicht geändert werden, bitte versuchen Sie es erneut.',
	'ERROR_NEWS_NOTCREATE'			=> 'Die Neuigkeit konnte leider nichterstellt werden, bitte versuchen Sie es erneut',
	'ERROR_NEWS_NOTUPDATE'			=> 'Die Neuigkeit konnte leider nicht geändert werden, bitte versuchen Sie es erneut!',
	/*/MSG ERROR */

	/* EXEPTION */
	'EXCEPTION_NOBUTTONS'				=> 'Es wurden keine Buttons gesetzt.',
	'EXCEPTION_SITE_NOTFOUND' 			=> 'Die Angeforderte Seite konnte leider nicht gefunden werden.',
	'EXCEPTION_SITE_NOTDELETE'			=> 'Die Seite konnte leider nicht gelöscht werden, bitte versuchen Sie es erneut.',
	'EXCEPTION_SITE_NOCONTENT'			=> 'Die Seite hat noch keinen Inhalt',
	'EXCEPTION_SITE_LANGUAGENOTDELETE'	=> 'Die Sprache konnte nicht gelöscht werden, bitte versuchen Sie es erneut.',
	'EXCEPTION_CONTENT_NOTFOUND'		=> 'Der Inhalt konnte leider nicht gefunden werden.',
	'EXCEPTION_CONTENT_NOTDELETE'		=> 'Der Inhalt konnte nicht gelöscht werden, bitte versuchen Sie es erneut.',
	'EXCEPTION_CONTENT_NOCONTENT'		=> 'Es wurde kein Kontent übertragen, der gespeichert werden soll.',
	'EXCEPTION_CONTENT_TEXTNOTUPDATE'	=> 'Die Änderungen konnten leider nicht gespeichert werden, bitte versuchen Sie es erneut.',
	'EXCEPTION_CONTENT_NOTADD2SITE'		=> 'EXCEPTION_CONTENT_NOTADD2SITE',
	'EXCEPTION_NEWS_NOTFOUND'			=> 'Die Neuigkeit konnte leider nicht gefunden werden',
	'EXCEPTION_NEWS_NOTDELETE'			=> 'Die Neuigeit konnte nicht gelöscht werden, versuchen Sie es erneut!',
	/*/EXEPTION */

	/* QUESTION */
	'QUESTION_EXIT_SITECREATE'		=> 'Möchten Sie wirklich die Seitenerstellung beenden? Die Seite wurde noch nicht angelegt.',
	'QUESTION_EXIT_SITEUPDATE'		=> 'Möchten Sie wirklich die Seitenbearbeitung beenden? Die Änderungen wurden noch nicht gespeichert.',
	'QUESTION_EXIT_CONTENTCREATE'	=> 'Möchten Sie wirklich die Inhalts-Bearbeitung beenden? Die Änderungen werden nicht übernommen.',
	'QUESTION_EXIT_CONTENTUPDATE'	=> 'Möchten Sie wirklich die Inhalts-Bearbeitung beenden? Alle Änderungen verloren.',
	'QUESTION_DELETE_SITE'			=> 'Möchten Sie die Seite wirklich löschen? Diese Änderung kann nicht wieder rückgänig gemacht werden.',
	'QUESTION_DELETE_CONTENT'		=> 'Möchten Sie den Inhalt wirklich löschen? Diese Änderungen kann nichtmehr rückgänig gemacht werden.',
	'QUESTION_EXIT_NEWSCREATE'		=> 'Möchten Sie wirklich die Neuigkeiten-Erstellung beenden? Die Neuigkeit wurde noch nicht erstellt!',
	'QUESTION_EXIT_NEWSUPDATE'		=> 'Möchten Sie wirklich die Neuigkeiten-Bearbeitung beenden? Die Änderungen wurden noch nicht gespeichert!',
	/*/QUESTION */
		
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
		Entwickelt von Maurice Busch, Alessio Bisgen, Lukas Schreck, Angela Gerstner.</br>',
	'TEST' 			=> 'This is a Test',
	'TEST_PARAM'		=> 'Test with params ###par1### and ###par2###',
);