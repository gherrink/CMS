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
class MenuController extends CRUDController implements CRUDReadModels
{

    public $defaultAction = 'read';
    
    protected $viewColumns = array(
        'label',
        array(
            'name' => 'roleaccess',
            'type' => 'raw',
            'value' => 'MsgPicker::msg()->getMessage($data->roleaccess)',
        ),
    );
    protected $rowExpression = '["id" => $data->menuid ."***". $data->label]';

    /**
     * @see CRUDController::findModel
     */
    public function findModel($name, $editLng)
    {
        return Menu::model()->findByAttributes(array('menuid' => $name,
                    'languageid' => $editLng));
    }
    
    /**
     * @see CRUDReadModels::getReadModels
     */
    public function getReadModels($name, $editLng)
    {
        return Menu::model()->findAll("languageid = '$editLng' AND parent_menuid IS NULL AND "
                        . "{$this->getRoleaccessSQLWhere()} ORDER BY position");
    }

    /**
     * @see CRUDController::getModelName
     */
    public function getModelName()
    {
        return 'Menu';
    }

    protected function modelCreate(CActiveRecord $model)
    {
        $model->menuid = Yii::app()->keygen->getUniquKey();
        $model->position = $model->countOnLevel();
        if ($model->insert())
        {
            if ($model->parent_menuid === null)
                $menu['before'] = '#menuitem';
            else
                $menu['before'] = '#menuitem-' . $model->parent_menuid;

            $menu['eval'][0] = "cmsMenuSetArrows();";
            $menu['html'] = $this->renderPartial('_menupoint', array('menupoint' => $model,
                'edit' => true), true);
            $menu['modalhide'] = 'modal';
            echo json_encode($menu);
            Yii::app()->end();
        }
    }

    protected function modelUpdate(CActiveRecord $model, CActiveRecord $dbModel)
    {
        $dbModel->roleaccess = $model->roleaccess;
        $dbModel->label = $model->label;
        $dbModel->url_intern = $model->url_intern;
        $dbModel->url = $model->url;
        $dbModel->site = $model->site;
        $dbModel->icon = $model->icon;
        if ($dbModel->parent_menuid !== $model->parent_menuid)
        {
            $dbModel->parent_menuid = $model->parent_menuid;
            $dbModel->position = $dbModel->countOnLevel();
        }

        if ($dbModel->update())
        {
            if ($model->parent_menuid !== $model->oldparent_menuid)
            {
                $menu['remove'] = '#' . $dbModel->menuid;
                if ($model->parent_menuid === null)
                    $menu['before'] = '#menuitem';
                else
                    $menu['before'] = '#menuitem-' . $model->parent_menuid;

                $menu['eval'][0] = "cmsMenuSetArrows();";
            }
            else
                $menu['replace'] = '#' . $dbModel->menuid;

            $menu['html'] = $this->renderPartial('_menupoint', array('menupoint' => $dbModel,
                'edit' => true), true);
            $menu['modalhide'] = 'modal';
            echo json_encode($menu);
            Yii::app()->end();
        }
    }

    protected function modelDelete(CActiveRecord $model)
    {
        $selector = '#' . $model->menuid;
        $where = "parent_menuid = '{$model->parent_menuid}' AND parent_languageid = '{$model->parent_languageid}' AND position > {$model->position}";
        $transaktion = Yii::app()->db->beginTransaction();
        if ($model->delete())
        {
            Menu::model()->updateCounters(array('position' => -1), $where);
            try
            {
                $transaktion->commit();
                $menu['remove'] = $selector;
                $menu['eval'][0] = "cmsMenuSetArrows();";
                echo json_encode($menu);
                Yii::app()->end();
            }
            catch (Exception $e)
            {
                
            }
        }

        $transaktion->rollBack();
    }
    
    public function actionRead($name = '', $edit = false, $editLng = '')
    {
        parent::actionRead($name, $edit, $editLng);
    }
    
    /**
     * echoes an json array with datas for a Icon-view with all available
     * icons.
     */
    public function actionIconView()
    {
        $icon['header'] = MsgPicker::msg()->getMessage(MSG::HEAD_MENU_ICONSELECT);
        $icon['body'] = $this->renderPartial('_iconselect', array(), true);
        $icon['footer'] = BsHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_EXIT), array(
                    'onclick' => "$('#modalmenu').modal('hide');"));
        echo json_encode($icon);
    }

    /**
     * Acton to move an menupoint on the same level up and down
     * @param string $name
     * @param string $editLng
     * @param int $move
     * @throws CHttpException
     */
    public function actionMoveMenupoint($name, $editLng, $move)
    {
        $this->checkAccess('editMenu');

        if (!is_numeric($move))
            throw new CHttpException(400, MsgPicker::msg()->getMessage(MSG::EXCEPTION_MENU_NEWPOSNOTCORREKT));

        $menu = Menu::model()->findByAttributes(array('menuid' => $name,
            'languageid' => $editLng));
        if ($menu === null)
            throw new CHttpException(400, MsgPicker::msg()->getMessage(MSG::EXCEPTION_MENU_NOTFOUND));

        $pos = $menu->position;
        $newpos = $pos + $move;

        if ($menu->parent_menuid === null)
            $where = 'parent_menuid IS NULL AND parent_languageid IS NULL';
        else
            $where = "parent_menuid = '{$menu->parent_menuid}' AND parent_languageid = '{$menu->parent_languageid}'";

        $count = Menu::model()->count($where);

        if ($newpos < 0 || $newpos > $count)
            throw new CHttpException(400, MsgPicker::msg()->getMessage(MSG::EXCEPTION_MENU_NEWPOSNOTCORREKT));

        $abovemenu = Menu::model()->find($where . " AND position = $newpos");

        if ($abovemenu === null)
            throw new CHttpException(400, MsgPicker::msg()->getMessage(MSG::EXCEPTION_MENU_NOTFOUND));

        $transaktion = Yii::app()->db->beginTransaction();
        if ($move > 0) // hochzählen
            Menu::model()->updateCounters(array('position' => -1), $where . " AND position <= $newpos AND position > $pos");
        else
            Menu::model()->updateCounters(array('position' => 1), $where . " AND position >= $newpos AND position < $pos");

        $menu->position = $newpos;
        $menu->update();

        try
        {
            $transaktion->commit();

            if ($pos == 0 || $newpos == $count - 1)
                $json['after'] = '#' . $abovemenu->menuid . '***#' . $menu->menuid;
            else
                $json['after'] = '#' . $menu->menuid . '***#' . $abovemenu->menuid;

            $json['eval'][0] = "cmsMenuSetArrows();";

            echo json_encode($json);
            Yii::app()->end();
        }
        catch (Exception $e)
        {
            
        }

        $transaktion->rollBack();
    }

}
