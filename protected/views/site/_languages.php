<?php
/**
 * @author Maurice Busch
 * @copyright 2014
 * @version 0.1
 */
/*
 * @var SiteLanguage[] $siteLanguages
 * @var BsActiveForm $form
 * @var Site $model
 */
?>

<h4><?php echo MsgPicker::msg()->getMessage(MSG::HEAD_SITE_CREATELANGUAGE) ?></h4>

<?php
$counter = 0;
if (isset($_POST['SiteLanguage']))
{
    foreach ($_POST['SiteLanguage'] as $attributs)
    {
        $siteLanguage = new SiteLanguage();
        $siteLanguage->attributes = $attributs;
        $this->renderPartial('_language', array('model' => $siteLanguage,
            'form' => $form, 'counter' => $counter++));
    }
}
else if ($model->siteid !== null && $model->siteid !== "")
{
    $siteLanguages = SiteLanguage::model()->findAllByAttributes(array(
        'siteid' => $model->siteid));
    echo BsHtml::hiddenField('site', $model->siteid);
    foreach ($siteLanguages as $siteLanguage)
        $this->renderPartial('_language', array('model' => $siteLanguage,
            'form' => $form, 'counter' => $counter++));
}
?>

<div id="new-language"></div>
<?php echo BsHtml::hiddenField('language-counter', $counter) ?>

<div class="row">
    <div class="col-sm-6">
        <?php
        $select = Yii::app()->language;
        $languages = SelectHelper::getActiveLanguages();
        echo BsHtml::dropDownList('language-select', $select, $languages);
        ?>
    </div>
    <div class="col-sm-6">
        <?php
        echo BsHtml::button(MsgPicker::msg()->getMessage(MSG::BTN_SITE_ADDLANGUAGE), array(
            'onclick' => 'addLanguage()'
        ));
        ?>
    </div>
</div>

<script type="text/javascript">
    function addLanguage()
    {
        var language = $('#language-select').val();
        var counter = +$('#language-counter').val() + 1;
        if ($("input[id$='languageid'][value='" + language + "']").length <= 0)
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl('site/newLanguage') ?>?lng=' + language + '&counter=' + counter,
                success: function(data, textStatus, jqXHR) {
                    $('#new-language').before(data);
                    $('#language-counter').val(counter);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    cmsShowErrorModal('modalmsg', jqXHR, textStatus, errorThrown);
                },
                dataType: 'html'
            });
        }
        else
            alert('<?php echo MsgPicker::msg()->getMessage(MSG::SITE_MSG_HEADLANGUAGEEXISTS) ?>');
    }

    function deleteLanguage(language)
    {
        if ($("input#site").length > 0)
            deleteLanguageAjax(language, $("input#site").val());
        else
            removeLanguage(language);
    }

    function deleteLanguageAjax(language, name)
    {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl('site/deleteLanguage') ?>?lng=' + language + '&name=' + name,
            success: function(data, textStatus, jqXHR) {
                removeLanguage(language);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                cmsShowErrorModal('modalmsg', jqXHR, textStatus, errorThrown);
            },
            dataType: 'html'
        });
    }

    function removeLanguage(language)
    {
        var ln = $("input[id$='languageid'][value='" + language + "']");
        if (ln.length > 0)
            ln.parent().parent().remove();
    }

</script>
