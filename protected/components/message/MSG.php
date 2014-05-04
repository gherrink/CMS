<?php
/**
 * Enthällt alle Message Konstanten
 * 
 * @author Maurice Busch <busch.maurice@gmx.net>
 * @copyright 2014
 * @version 0.1
 *
 */
class MSG
{
	
	/* Rollen */
	const ADMIN 	= 'ADMIN';
	const MCALENDER = 'MCALENDER';
	const MGALLERY 	= 'MGALLERY';
	const MSITE 	= 'MSITE';
	const MMENU 	= 'MMENU';
	const MNEWS 	= 'MNEWS';
	const MEMBER 	= 'MEMBER';
	const USER 		= 'USER';
	const VISITOR 	= 'VISITOR';
	/*/Rollen */
	
	/* Layouts */
	const COL01		= 'COL01';
	/*/Layouts */
	
	/* Menu Punkte */
	const MP_LOGIN						= 'MP_LOGIN';
	const MP_LOGOUT 					= 'MP_LOGOUT';
	const MP_CONTACT					= 'MP_CONTACT';
	const MP_USER_REGISTERASMEMBER 		= 'MP_USER_REGISTERASMEMBER';
	const MP_NEWS						= 'MP_NEWS';
	const MP_GALLERY					= 'MP_GALLERY';
	const MP_MODERATOR					= 'MP_MODERATOR';
	const MP_MODERATOR_SITE				= 'MP_MODERATOR_SITE';
	const MP_MODERATOR_SITECREATE		= 'MP_MODERATOR_SITECREATE';
	const MP_MODERATOR_CONTENTCREATE	= 'MP_MODERATOR_CONTENTCREATE';
	/*/Menu Punkte */
	
	/* Ueberschriften */
	const HEAD_QUESTION_REALYCLOSE			= 'HEAD_QUESTION_REALYCLOSE';
	const HEAD_QUESTION_REALYDELETE			= 'HEAD_QUESTION_REALYDELETE';
	const HEAD_CONTACT						= 'HEAD_CONTACT';
	const HEAD_LOGIN						= 'HEAD_LOGIN';
	const HEAD_REGISTER						= 'HEAD_REGISTER';
	const HEAD_CHANGEMAIL					= 'HEAD_CHANGEMAIL';
	const HEAD_SITE_CREATELANGUAGE			= 'HEAD_SITE_CREATELANGUAGE';
	const HEAD_CONTENT_CREATE				= 'HEAD_CONTENT_CREATE';
	const HEAD_CONTENT_ADD2SITE				= 'HEAD_CONTENT_ADD2SITE';
	/*/Ueberschriften */
	
	/* Buttons */
	const BTN_OK					= 'BTN_OK';
	const BTN_YES					= 'BTN_YES';
	const BTN_NO					= 'BTN_NO';
	const BTN_REGISTER				= 'BTN_REGISTER';
	const BTN_EDIT					= 'BTN_EDIT';
	const BTN_CREATE				= 'BTN_CREATE';
	const BTN_UPDATE				= 'BTN_UPDATE';
	const BTN_DELETE				= 'BTN_DELETE';
	const BTN_EXIT					= 'BTN_EXIT';
	const BTN_NEW_CONTENT			= 'BTN_NEW_CONTENT';
	const BTN_SITE_ADDLANGUAGE		= 'BTN_SITE_ADDLANGUAGE';
	/*/Buttons */
	
	/* Models */
	const MODEL_LABEL		= 'MODEL_LABEL';
	const MODEL_ROLE		= 'MODEL_ROLE';
	const MODEL_LANGUAGE	= 'MODEL_LANGUAGE';
	/*/Models */
	
	/* Contact */
	const CONTACT_INFO		= 'CONTACT_INFO';
	const CONTACT_NAME		= 'CONTACT_NAME';
	const CONTACT_MAIL		= 'CONTACT_MAIL';
	const CONTACT_SUBJECT	= 'CONTACT_SUBJECT';
	const CONTACT_BODY		= 'CONTACT_BODY';
	/*/Contact */
	
	/* User */
	const USER_USER 		= 'USER_USER';
	const USER_FIRSTNAME 	= 'USER_FIRSTNAME';
	const USER_LASTNAME 	= 'USER_LASTNAME';
	const USER_PASSWORD 	= 'USER_PASSWORD';
	const USER_PASSWORDREP 	= 'USER_PASSWORDREP';
	const USER_MAIL			= 'USER_MAIL';
	const USER_MSG_USER		= 'USER_MSG_USER';
	const USER_MSG_PASSWORD	= 'USER_MSG_PASSWORD';
	/*/User */
	
	/* Site */
	const SITE_LAYOUT					= 'SITE_LAYOUT';
	const SITE_MSG_MATCH				= 'SITE_MSG_MATCH';
	const SITE_MSG_LABELEXISTS			= 'SITE_MSG_LABELEXISTS';
	const SITE_MSG_HEADLANGUAGEEXISTS	= 'SITE_MSG_HEADLANGUAGEEXISTS';
	/*/Site */
	
	/* MSG SUCCESS */
	const SUCCESS_CONTACT_SENDMAIL		= 'SUCCESS_CONTACT_SENDMAIL';
	const SUCCESS_LOGIN_REGISTER		= 'SUCCESS_LOGIN_REGISTER';
	const SUCCESS_LOGIN_USERVALIDATE	= 'SUCCESS_LOGIN_USERVALIDATE';
	const SUCCESS_LOGIN_RESENDMAIL		= 'SUCCESS_LOGIN_RESENDMAIL';
	const SUCCESS_LOGIN_MAILCHANGE		= 'SUCCESS_LOGIN_MAILCHANGE';
	const SUCCESS_SITE_CREATE			= 'SUCCESS_SITE_CREATE';
	const SUCCESS_SITE_UPDATE			= 'SUCCESS_SITE_UPDATE';
	/*/MSG SUCCESS */
	
	/* MSG WARNING */
	const WARNING_LOGIN_MAILNOTVALID		= 'WARNING_LOGIN_MAILNOTVALID';
	const WARNING_LOGIN_SENDREGISTERMAIL	= 'WARNING_LOGIN_SENDREGISTERMAIL';
	/*/MSG WARNING */
	
	/* MSG ERROR */
	const ERROR_CONTACT_SENDMAIL		= 'ERROR_CONTACT_SENDMAIL';
	const ERROR_LOGIN_PWWRONG			= 'ERROR_LOGIN_PWWRONG';
	const ERROR_LOGIN_NOTREGISTERED		= 'ERROR_LOGIN_NOTREGISTERED';
	const ERROR_LOGIN_USERVALIDATE		= 'ERROR_LOGIN_USERVALIDATE';
	const ERROR_LOGIN_RESENDMAIL		= 'ERROR_LOGIN_RESENDMAIL';
	const ERROR_LOGIN_MAILCHANGE		= 'ERROR_LOGIN_MAILCHANGE';
	/*/MSG ERROR */
	
	/* EXCEPTION */
	const EXCEPTION_NOBUTTONS					= 'EXCEPTION_NOBUTTONS';
	const EXCEPTION_SITE_NOTFOUND				= 'EXCEPTION_SITE_NOTFOUND';
	const EXCEPTION_SITE_NOCONTENT				= 'EXCEPTION_SITE_NOCONTENT';
	const EXCEPTION_SITE_LANGUAGENOTDELETE		= 'EXCEPTION_SITE_LANGUAGENOTDELETE';
	const EXCEPTION_CONTENT_NOTFOUND			= 'EXCEPTION_CONTENT_NOTFOUND';
	const EXCEPTION_CONTENT_NOCONTENT			= 'EXCEPTION_CONTENT_NOCONTENT';
	const EXCEPTION_CONTENT_TEXTNOTUPDATE		= 'EXCEPTION_CONTENT_TEXTNOTUPDATE';
	const EXCEPTION_CONTENT_NOTADD2SITE			= 'EXCEPTION_CONTENT_NOTADD2SITE';
	/*/EXCEPTION */
	
	/* QUESTION */
	const QUESTION_DELEATE_SITE				= 'QUESTION_DELEATE_SITE';
	const QUESTION_DELEATE_CONTENT			= 'QUESTION_DELEATE_CONTENT';
	/*/QUESTION */
	
	/* MAIL */
	const MAIL_SUBJECT_REGISTER 	= 'MAIL_SUBJECT_REGISTER';
	const MAIL_BODY_REGISTER		= 'MAIL_BODY_REGISTER';
	/*/MAIL */
	
	const VERIFY			= 'VERIFY';
	const VERIFY_INFO		= 'VERIFY_INFO';
	const CREATE_USER_TIME	= 'CREATE_USER_TIME';
	const UPDATE_USER_TIME	= 'UPDATE_USER_TIME';
	const FOOTER			= 'FOOTER';
	const TEST 				= 'TEST';
	const TEST_PARAM 		= 'TEST_PARAM';
}