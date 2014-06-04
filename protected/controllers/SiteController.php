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
 *
 * @author Maurice Busch <busch.maurice@gmx.net>
 */
class SiteController extends CRUDController implements CRUDReadParams, CRUDReadCheck, CRUDEditParams, CRUDVisitHelper
{

    /**
     * @see CRUDController::getModelName
     */
    public function getModelName()
    {
        return 'Site';
    }

    /**
     * @see CRUDController::findModel
     */
    public function findModel($name = '', $editLng = '')
    {
        return Site::model()->findByAttributes(array('label' => $name));
    }

    /**
     * @see CRUDReadParams::getReadParams
     */
    public function getReadParams($name, $editLng)
    {
        return array('layout' => $this->getModel()->layout);
    }

    /**
     * @see CRUDReadCheck::checkReadable
     */
    public function checkReadable(CActiveRecord $model, $editable)
    {
        if ($editable)
            return true;

        $sql = "SELECT COUNT(*) FROM SiteContentView WHERE siteid = '{$model->siteid}' AND languageid = '" . Yii::app()->language . "' AND {$this->getRoleaccessSQLWhere()}";
        if (SiteContentView::model()->countBySql($sql) <= 0)
            throw new CHttpException(500, MsgPicker::msg()->getMessage(MSG::EXCEPTION_SITE_NOCONTENT));

        return true;
    }

    /**
     *
     * @param CActiveRecord $model
     * @return string Error
     */
    protected function modelCreate(CActiveRecord $model)
    {
        $model->siteid = Yii::app()->keygen->getUniquKey();
        $model->layout = strtolower($model->layout);

        $transaktion = Yii::app()->db->beginTransaction();
        if ($model->insert() && $this->createSiteHeader($model))
            try
            {
                $transaktion->commit();
                $content['success'] = Yii::app()->createAbsoluteUrl('site/edit', array(
                    'name' => $model->label));
                echo json_encode($content);
                Yii::app()->end();
            }
            catch (Exception $e)
            {
                
            }

        $transaktion->rollBack();
    }

    private function createSiteHeader(Site $site)
    {
        if (!isset($_POST['SiteLanguage']))
            return true;

        foreach ($_POST['SiteLanguage'] as $siteAttributes)
        {
            $siteLangauge = new SiteLanguage();
            $siteLangauge->attributes = $siteAttributes;
            $siteLangauge->siteid = $site->siteid;
            if (!$siteLangauge->insert())
                return false;
        }

        return true;
    }

    /**
     *
     * @param CActiveRecord $model
     * @param CActiveRecord $dbModel
     * @return string Error
     */
    protected function modelUpdate(CActiveRecord $model, CActiveRecord $dbModel)
    {
        $dbModel->layout = strtolower($model->layout);
        $dbModel->roleaccess = $model->roleaccess;
        $dbModel->label = $model->label;

        $transaktion = Yii::app()->db->beginTransaction();
        if ($dbModel->update() && $this->updateSiteHeader($dbModel))
            try
            {
                $transaktion->commit();
                $content['success'] = Yii::app()->createAbsoluteUrl('site/edit', array(
                    'name' => $dbModel->label));
                echo json_encode($content);
                Yii::app()->end();
            }
            catch (Exception $e)
            {
                
            }

        $transaktion->rollBack();
        return BsHtml::alert(BsHtml::ALERT_COLOR_ERROR, MsgPicker::msg()->getMessage(MSG::ERROR_SITE_NOTUPDATE));
    }

    private function updateSiteHeader(Site $site)
    {
        if (!isset($_POST['SiteLanguage']))
            return true;
        
        foreach ($_POST['SiteLanguage'] as $siteAttributes)
        {
            $siteLangauge = new SiteLanguage();
            $siteLangauge->attributes = $siteAttributes;
            $siteLanguageDB = SiteLanguage::model()->findByAttributes(array(
                'siteid' => $site->siteid, 'languageid' => $siteLangauge->languageid));
            if ($siteLanguageDB === null)
            {
                $siteLangauge->siteid = $site->siteid;
                if (!$siteLangauge->insert())
                    return false;
            }
            else
            {
                $siteLanguageDB->head = $siteLangauge->head;
                if (!$siteLanguageDB->update())
                    return false;
            }
        }

        return true;
    }
    
    public function getEditParams(\CActiveRecord $model)
    {
        $params['roles'] = DbAuthManager::getRolesSite();
        $params['layouts'] = LayoutManager::getLayouts();

        $params['selectedRole'] = DbAuthManager::getDefaultSiteRole();
        if ($model->roleaccess !== null)
            $params['selectedRole'] = $model->roleaccess;

        $params['selectedLayout'] = LayoutManager::getDefaultLayout();
        if ($model->layout !== null)
            $params['selectedLayout'] = $model->layout;
        
        return $params;
    }

    protected function modelDelete(CActiveRecord $model)
    {
        if ($model->delete())
        {
            echo json_encode(array('success' => Yii::app()->createAbsoluteUrl('site')));
            Yii::app()->end();
        }
    }
    
    public function logVisit()
    {
        $model = $this->getModel();
        if($model != null)
            VisitHelper::siteVisit($model->siteid);
    }

    /**
     * This is the default 'index' action that renders
     * the Homepage.
     */
    public function actionIndex()
    {
        $this->render('index');
    }

    /**
     * Add new Site header language
     * @param string $lng
     * @param int $counter
     */
    public function actionNewLanguage($lng, $counter)
    {
        $this->checkAccess('addSiteNewLanguage');

        $siteLanguage = new SiteLanguage();
        $siteLanguage->languageid = $lng;
        $this->renderPartial('_language', array('counter' => $counter,
            'model' => $siteLanguage, 'form' => new BsActiveForm()));
    }

    /**
     * Delete Site header language
     * @param string $name
     * @param string $language
     * @throws CHttpException
     */
    public function actionDeleteLanguage($name, $lng)
    {
        $this->checkAccess('deleteSiteLanguage');

        if (!SiteLanguage::model()->deleteAllByAttributes(array('siteid' => $name,
                'languageid' => $language)))
            throw new CHttpException(500, MsgPicker::msg()->getMessage(MSG::EXCEPTION_SITE_LANGUAGENOTDELETE));
    }

    /**
     * Delets content form site
     * @param unknown $site
     * @param unknown $con
     * @param unknown $lng
     * @throws CHttpException
     */
    public function actionDeleteContent($site, $con)
    {
        $siteCon = SiteContent::model()->findByAttributes(array('siteid' => $site,
            'contentid' => $con));

        if ($siteCon === null)
            throw new CHttpException(500, MsgPicker::msg()->getMessage(MSG::EXCEPTION_CONTENT_NOTFOUND));

        $pos = $siteCon->position;

        $transaktion = Yii::app()->db->beginTransaction();
        if ($siteCon->delete() && $this->moveContentPos($site, 'position > ' . $pos, -1))
            try
            {
                $transaktion->commit();
                $content['remove'] = '#' . $con;
                echo json_encode($content);
                Yii::app()->end();
            }
            catch (Exception $e)
            {
                
            }

        $transaktion->rollBack();
    }

    private function moveContentPos($site, $sqlPos, $move)
    {
        $siteContents = SiteContent::model()->findAll("siteid='$site' AND " . $sqlPos);
        foreach ($siteContents as $siteContent)
        {
            $siteContent->position = $siteContent->position + $move;
            if (!$siteContent->update())
                return false;
        }

        return true;
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error)
        {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

}
