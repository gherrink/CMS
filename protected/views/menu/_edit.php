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
 * @author Maurice Busch <busch.maurice@gmx.net>
 */

/*
 * @var MenuController $this 
 * @var Menu $model
 * @var BsActiveForm $form
 */

$form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    'layout' => BsHtml::FORM_LAYOUT_VERTICAL,
    'enableAjaxValidation' => false,
    'id' => 'menu-form',
    'htmlOptions' => array(
        'onsubmit' => "return false;",
        'onkeypress' => " if(event.keyCode == 13){ cmsSubmitForm('modal', 'menu-form', '" . $url . "'); } ",
    ),
    ));
?>

<div class="row">
    <div class="col-sm-9">
        <?php
        echo $form->textFieldControlGroup($model, 'label', array(
            'labelOptions' => array('class' => 'col-lg-4'),
            'controlOptions' => array('class' => 'col-lg-8'),
        ));
        echo $form->hiddenField($model, 'languageid');
        ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-9">
        <?php
        echo $form->textFieldControlGroup($model, 'parent_menu', array(
            'labelOptions' => array('class' => 'col-lg-4'),
            'controlOptions' => array('class' => 'col-lg-8'),
            'disabled' => true,
        ));
        echo $form->hiddenField($model, 'oldparent_menuid');
        echo $form->hiddenField($model, 'parent_menuid');
        echo $form->hiddenField($model, 'parent_languageid');
        ?>
    </div>
    <div class="col-sm-3 btn-group">
        <?php
        $url = Yii::app()->createAbsoluteUrl('menu/view', array('head' => MSG::HEAD_MENU_PARENTMENU));
        $json = json_encode(array('buttons' => array(
                MSG::BTN_EXIT => "$('#modalmenu').modal('hide');",
                MSG::BTN_OK => "cmsMenuInsertParent();",
        )));

        echo BsHtml::button('', array(
            'icon' => BsHtml::GLYPHICON_SEARCH,
            'onclick' => "cmsShowModalAjax('modalmenu', '$url', $json);",
        ));
        echo BsHtml::button('', array(
            'icon' => BsHtml::GLYPHICON_REMOVE,
            'onclick' => 'cmsMenuRemoveParent();',
        ));
        ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-9">
        <div class="form-group">
            <?php
            echo $form->label($model, 'haschilds', array(
                'class' => 'control-label col-lg-4'));
            ?>
            <div class="col-lg-8" style="padding-top: 12px">
                <?php
                echo $form->checkBox($model, 'haschilds', array(
                    'class' => 'control-label',
                    'onchange' => 'cmsMenuChangeUrl()',
                ));
                ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-9">
        <div class="form-group">
            <?php
            echo $form->label($model, 'url_intern', array(
                'class' => 'control-label col-lg-4'));
            ?>
            <div class="col-lg-8" style="padding-top: 12px">
                <?php
                echo $form->checkBox($model, 'url_intern', array(
                    'class' => 'control-label',
                    'onchange' => 'cmsMenuChangeUrl()',
                    'disabled' => $model->haschilds,
                ));
                ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-9">
        <?php
        echo $form->textFieldControlGroup($model, 'url', array(
            'labelOptions' => array('class' => 'col-lg-4'),
            'controlOptions' => array('class' => 'col-lg-8'),
            'disabled' => ($model->url_intern || $model->haschilds),
        ));
        ?>
    </div>
    <div class="col-sm-3">
        <?php
        $url = Yii::app()->createAbsoluteUrl('site/view', array('head' => MSG::HEAD_MENU_LINK2SITE));
        $json = json_encode(array('buttons' => array(
                MSG::BTN_EXIT => "$('#modalmenu').modal('hide');",
                MSG::BTN_OK => "cmsMenuInsertLink();",
        )));


        echo BsHtml::button('', array(
            'icon' => BsHtml::GLYPHICON_SEARCH,
            'onclick' => "cmsShowModalAjax('modalmenu', '$url', $json);",
            'disabled' => !$model->url_intern,
            'id' => 'link-select',
        ));
        ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-9">
        <?php
        echo $form->dropDownListControlGroup($model, 'roleaccess', $roles, array(
            'options' => array($selectedRole => array('selected' => true)),
            'labelOptions' => array('class' => 'col-lg-4'),
            'controlOptions' => array('class' => 'col-lg-8')
        ));
        ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-9">
            <?php echo $form->hiddenField($model, 'icon') ?>
            <?php echo $form->label($model, 'icon', array(
                'class' => 'control-label col-lg-4')); ?>
        <div class="col-lg-8">
            <?php
            if ($model->icon !== null && $model->icon !== '')
                echo BsHtml::icon($model->icon, array('class' => 'control-label',
                    'id' => 'menuicon'));
            else
                echo BsHtml::icon('', array('class' => 'control-label',
                    'id' => 'menuicon'));
            ?>
        </div>
    </div>
    <div class="col-sm-3 btn-group">
        <?php
        $url = Yii::app()->createAbsoluteUrl('menu/iconView');

        echo BsHtml::button('', array(
            'icon' => BsHtml::GLYPHICON_SEARCH,
            'onclick' => "cmsShowModalAjax('modalmenu', '$url');",
        ));
        echo BsHtml::button('', array(
            'icon' => BsHtml::GLYPHICON_REMOVE,
            'onclick' => 'cmsMenuRemoveIcon()',
        ));
        ?>
    </div>
</div>

<?php
$this->endWidget();
