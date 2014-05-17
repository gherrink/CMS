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
 * Implementation of the Content Controller this controller will 
 * alow the user to create, read, update and delete content. It also
 * alows a user to add content to a site
 * @author Maurice Busch <busch.maurice@gmx.net>
 */
class ContentController extends CRUDController implements CRUDEditParams
{

    /**
     * @see CRUDController::findModel
     */
    public function findModel($name, $editLng)
    {
        return Content::model()->findByAttributes(array('label' => $name));
    }

    /**
     * @see CRUDController::getModelName
     */
    public function getModelName()
    {
        return 'Content';
    }

    /**
     * Creats a Site model and saves it to the DB and redirects the
     * user to the new site.
     * @param CActiveRecord $model
     */
    protected function modelCreate(CActiveRecord $model)
    {
        $model->contentid = Yii::app()->keygen->getUniquKey();
        if ($model->insert())
        {
            $url = Yii::app()->createAbsoluteUrl('content/edit', array(
                'name' => $model->label));
            echo json_encode(array('success' => $url));
            Yii::app()->end();
        }
    }

    /**
     * Updates the $dbModel with the $model and saves the changes to 
     * the DB.
     * @param CActiveRecord $model
     * @param CActiveRecord $dbModel
     */
    protected function modelUpdate(CActiveRecord $model, CActiveRecord $dbModel)
    {
        $dbModel->roleaccess = $model->roleaccess;
        $dbModel->label = $model->label;
        $dbModel->languageid = $model->languageid;

        if ($dbModel->update())
        {
            $url = Yii::app()->createAbsoluteUrl('content/edit', array(
                'name' => $dbModel->label));
            echo json_encode(array('success' => $url));
            Yii::app()->end();
        }
    }
    
    public function getEditParams(\CActiveRecord $model)
    {
        $params['roles'] = DbAuthManager::getRolesSite();
        $params['languages'] = Language::getActiveLanguages();

        $params['selectedRole'] = DbAuthManager::defaultSiteRole();
        if ($model->roleaccess !== null)
            $params['selectedRole'] = $model->roleaccess;

        $params['selectedLanguage'] = Yii::app()->language;
        if ($model->languageid !== null)
            $params['selectedLanguage'] = $model->languageid;
        
        return $params;
    }

    /**
     * Delets the Content and redirects the user to the default site action.
     * @param CActiveRecord $model
     */
    protected function modelDelete(CActiveRecord $model)
    {
        if ($model->delete())
        {
            echo json_encode(array('success' => Yii::app()->createAbsoluteUrl('site')));
            Yii::app()->end();
        }
    }

    /**
     * Saves text to the of a content.
     * @param string $name
     */
    public function actionSaveText($name)
    {
        $this->checkAccess('updateContentText');

        if (!isset($_POST['content']))
            throw new CHttpException(400, MsgPicker::msg()->getMessage(MSG::EXCEPTION_CONTENT_NOCONTENT));

        $content = Content::model()->findByPk($name);
        if ($content === null)
            throw new CHttpException(400, MsgPicker::msg()->getMessage(MSG::EXCEPTION_CONTENT_NOTFOUND));

        $content->text = $_POST['content'];
        if (!$content->update())
            throw new CHttpException(400, MsgPicker::msg()->getMessage(MSG::EXCEPTION_CONTENT_TEXTNOTUPDATE));
    }

    /**
     * Adds a $content to a $site
     * @param string $content
     * @param string $site
     * @param int $col
     * @throws CHttpException
     */
    public function actionAddContent2Site($content, $site, $col = 1, $onSite = false)
    {
        $this->checkAccess('addSiteContent');

        if ($content === 'undefined' || $site === 'undefined')
            throw new CHttpException(400, MsgPicker::msg()->getMessage(MSG::EXCEPTION_NOTHINGSELECTED));

        $mSite = Site::model()->findByAttributes(array('label' => $site));
        if ($mSite === null)
            throw new CHttpException(400, MsgPicker::msg()->getMessage(MSG::EXCEPTION_SITE_NOTFOUND));

        $mContent = Content::model()->findByAttributes(array('label' => $content));
        if ($mContent === null)
            throw new CHttpException(400, MsgPicker::msg()->getMessage(MSG::EXCEPTION_CONTENT_NOTFOUND) . $content);

        $conditions = "siteid = '{$mSite->siteid}' AND contentid = '{$mContent->contentid}'";
        if (SiteContent::model()->exists($conditions))
            throw new CHttpException(400, MsgPicker::msg()->getMessage(MSG::EXCEPTION_SITECONTENT_EXISTS));

        $siteContent = new SiteContent();
        $siteContent->siteid = $mSite->siteid;
        $siteContent->contentid = $mContent->contentid;
        $siteContent->position = SiteContent::getLastPosition($site) +
            1;
        $siteContent->col = $col;

        if (!$siteContent->insert())
            throw new CHttpException(500, MsgPicker::msg()->getMessage(MSG::EXCEPTION_CONTENT_NOTADD2SITE));

        $this->renderSiteContent($onSite, $mContent, $mSite);
    }

    /**
     * Renders the new Content and gives it over as JSON array. If the
     * user prassed add2site on a content-view he will redirected to the
     * site he have added the content. If the user is on a site-view
     * and he wants to add a new content the content will be added @ the
     * end of the site.
     * @param boolean $onSite
     * @param Content $mContent
     * @param Site $mSite
     */
    public function renderSiteContent($onSite, Content $mContent, Site $mSite)
    {
        if ($onSite)
        {
            $newContent['before'] = '#newContent';
            $newContent['html'] = $this->renderPartial('_content', array(
                'model' => $mContent, 'edit' => true, 'editable' => false,
                'site' => $mSite->siteid), true);
            $newContent['aloha'] = true;
            echo json_encode($newContent);
        }
        else
            echo json_encode(array('success' => Yii::app()->createAbsoluteUrl('site/edit', array(
                    'name' => $mSite->label))));
    }

}
