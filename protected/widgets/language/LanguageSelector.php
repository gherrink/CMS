<?php

/**
 * Creates a Dropdown to select the Language
 * @author Maurice Busch <busch.maurice@gmx.net>
 * @copyright 2014
 * @version 0.1
 *
 */
class LanguageSelector extends CWidget
{

    /**
     * The selected Language;
     * @var string
     */
    public $selectedLanguage = '';

    /**
     * All available Languages
     * @var Language[]
     */
    public $languages = null;

    /**
     * Display Flag-Images
     * @var boolean
     */
    public $showFlags = false;

    /**
     * Display the Label for the User
     * @var boolean
     */
    public $showLabel = true;

    /**
     * Base rout for the URL
     * controller/action
     * @var string
     */
    public $rout = '';

    /**
     * parameter for the URL
     * @var array
     */
    public $params = null;

    /**
     * ID for languages in $params
     * @var string
     */
    public $languageid = 'language';

    /**
     * Put the LanguageDropdown into a Menu
     * @var bollean
     */
    public $inMenu = false;

    /**
     * translate the Labels
     * @var boolean
     */
    public $translate = false;
    private $activeLanguage;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        if ($this->selectedLanguage === '' || !MsgPicker::isAvailable($this->selectedLanguage) ||
                !Language::isLanguageActive($this->selectedLanguage))
            $this->selectedLanguage = Yii::app()->language;

        $this->activeLanguage = Language::model()->findByAttributes(array('languageid' => $this->selectedLanguage));

        if ($this->languages === null)
            $this->languages = Language::model()->findAllByAttributes(array('active' => 1));

        if (!$this->showFlags && !$this->showLabel)
            $this->showLabel = true;

        if ($this->rout === '')
            $this->rout = Yii::app()->controller->id . '/' . Yii::app()->controller->action->id;

        if ($this->params === null)
            $this->params = $_GET;
        
        $this->languageid = str_replace(' ', '', $this->languageid);
    }

    /**
     * Runs the widget.
     */
    public function run()
    {
        if ($this->activeLanguage === null)
            return false;

        if (!$this->inMenu)
            echo '<div class="btn-group">';

        if ($this->inMenu)
        {
            echo '<li>';
            echo $this->printFlagLink($this->activeLanguage, true);
        }
        else
        {
            $display = '';
            if ($this->showLabel)
                if ($this->translate)
                    $display .= MsgPicker::msg()->getMessage(strtoupper($this->activeLanguage->languageid));
                else
                    $display .= $this->activeLanguage->label;

            echo '<button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">' . $display . '<span class="caret"></span></button>';
        }

        echo '<ul role="menu" class="dropdown-menu">';
        foreach ($this->languages as $language)
        {
            echo "<li>";
            $this->printFlagLink($language);
            echo "</li>";
        }
        echo '</ul>';

        if ($this->inMenu)
            echo '</li>';
        else
            echo '</div>';
    }

    private function printFlagLink(Language $language, $menu = false)
    {
        foreach (mb_split(',', $this->languageid) as $id)
            $this->params[$id] = $language->languageid;

        if ($menu)
            $link = '#" class="dropdown-toggle" data-toggle="dropdown';
        else
            $link = Yii::app()->createAbsoluteUrl($this->rout, $this->params);

        $link = '<a href="' . $link . '">';

// 		if($this->showFlags)
// 			$link .= '<img scr="" class="'.$this->getFlagClass($language->languageid).'" />';

        if ($this->showLabel)
            if ($this->translate)
                $link .= MsgPicker::msg()->getMessage(strtoupper($language->languageid));
            else
                $link .= $language->label;

        if ($menu)
            $link .= '<span class="caret"></span>';

        $link .= '</a>';
        echo $link;
    }

// 	private function getFlagClass($language)
// 	{
// 		return 'flag flag-'.$language;
// 	}
}
