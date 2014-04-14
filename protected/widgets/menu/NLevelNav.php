<?php

class NLevelNav extends CWidget
{
    /**
     * @var string the navbar color.
     */
    public $color = BsHtml::NAVBAR_COLOR;
    /**
     * @var string the brand label text.
     */
    public $brandLabel;
    /**
     * @var mixed the brand url.
     */
    public $brandUrl;
    /**
     * @var array the HTML attributes for the brand link.
     */
    public $brandOptions = array();
    /**
     * @var string nanvbar display type.
     */
    public $position = BsHtml::NAVBAR_POSITION;
    /**
     * @var boolean whether to enable collapsing of the navbar on narrow screens.
     */
    public $collapse = false;
    /**
     * @var array additional HTML attributes for the collapse widget.
     */
    public $collapseOptions = array();
    /**
     * @var array list of navbar item.
     */
    public $items = array();
    public $menu = array();
    /**
     * @var array the HTML attributes for the navbar.
     */
    public $htmlOptions = array();

    /**
     * add from 3.0.2 because navbar fixed top need actually an container
     * @var bool
     */
    public $container = false;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        if ($this->brandLabel !== false) {
            if (!isset($this->brandLabel)) {
                $this->brandLabel = CHtml::encode(Yii::app()->name);
            }

            if (!isset($this->brandUrl)) {
                $this->brandUrl = Yii::app()->homeUrl;
            }
        }
        if (isset($this->color)) {
            BsArray::defaultValue('color', $this->color, $this->htmlOptions);
        }
        if (isset($this->position) && $this->position !== BsHtml::NAVBAR_POSITION) {
            BsArray::defaultValue('position', $this->position, $this->htmlOptions);
        }
        
        $js =<<<EOP
$(function(){
	$(".dropdown-menu > li > a.trigger").on("click",function(e){
		var current=$(this).next();
		var grandparent=$(this).parent().parent();
		if($(this).hasClass('left-caret')||$(this).hasClass('right-caret'))
			$(this).toggleClass('right-caret left-caret');
		grandparent.find('.left-caret').not(this).toggleClass('right-caret left-caret');
		grandparent.find(".sub-menu:visible").not(current).hide();
		current.toggle();
		e.stopPropagation();
	});
	$(".dropdown-menu > li > a:not(.trigger)").on("click",function(){
		var root=$(this).closest('.dropdown');
		root.find('.left-caret').toggleClass('right-caret left-caret');
		root.find('.sub-menu:visible').hide();
	});
});
EOP;
        
        Yii::app()->clientScript->registerScript('nlevelnav', $js);
    }

	/**
	 * Runs the widget.
	 */
	public function run()
	{
		echo '<nav class="navbar navbar-default" role="navigation">';
		echo '<div class="navbar-header">
<button class="navbar-toggle collapsed" type="button" data-target="#menu-toggle" data-toggle="collapse">
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>';
		if($this->brandLabel)
			echo BsHtml::navbarBrandLink($this->brandLabel, $this->brandUrl, $this->brandOptions);
		echo '</div>';
		
		echo '<div id="menu-toggle" class="collapse navbar-collapse">';
		$this->buildNav($this->items, 'nav navbar-nav', false);
		$this->buildNav($this->menu, 'pull-right nav navbar-nav', false);
		echo '</div>';
		echo '</nav>';
    }
    
    private function buildNav($items, $class, $submenu)
    {
	    echo '<ul class="'.$class.'" role="menu">';
	    foreach ($items as $item)
		{
			if(count($item) > 0)
				if(!array_key_exists('visible', $item) || array_key_exists('visible', $item) && $item['visible'])
				{
					echo '<li>';
					
					if(! array_key_exists('url', $item))
						$item['url'] = '#';
					
					if(! array_key_exists('items', $item) || (count($item) <= 0))
						echo CHtml::link($item['label'], $item['url']);
					else 
					{
						if($submenu)
							echo CHtml::link($item['label'], '#', array('class'=>'trigger right-caret', 'data-toggle'=>'dropdown'));
						else
							echo CHtml::link($item['label'].'<span class="caret"></span>', '#', array('class'=>'dropdown-toggle', 'data-toggle'=>'dropdown'));
						
						if(count($item['items']) > 0)
							$this->buildNav($item['items'], 'dropdown-menu sub-menu', true);
					}
					echo '</li>';
				}
		}
		echo '</ul>';
    }
}