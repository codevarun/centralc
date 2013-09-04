<?php
/**
 * @version   $Id: RokSprocket_Layout_Mosaic.php 1023 2012-05-31 21:00:25Z josh $
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2012 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

class RokSprocket_Layout_Mosaic extends RokSprocket_AbstractLayout
{
	/**
	 * @var bool
	 */
	protected static $instanceHeadersRendered = false;

	/**
	 * @var string
	 */
	protected $name = 'mosaic';
	protected $tagging = array("all" => "");


	protected function cleanItemParams()
	{

		$this->tagging['all'] = rc__('ALL');

		foreach ($this->items as $item_id => &$item) {

			$item->setPrimaryImage($this->setupImage($item, 'mosaic_image_default', 'mosaic_image_default_custom', 'mosaic_item_image'));
			$item->setPrimaryLink($this->setupLink($item,'mosaic_link_default','mosaic_link_default_custom', 'mosaic_item_link'));
			$item->setTitle($this->setupText($item,'mosaic_title_default','mosaic_title_default_custom','mosaic_item_title'));
			$item->setText($this->setupText($item,'mosaic_description_default','mosaic_description_default_custom','mosaic_item_description'));

			// clean from tags and limit words amount
			$words_amount = $this->parameters->get('mosaic_previews_length', 20);
			$stripped = strip_tags($item->getText());
			$preview = $this->_getWords($stripped, $words_amount);

			$append = strlen($stripped) != strlen($preview) ? "…" : "";
			$item->setText($preview . $append);

			// resizing images if needed
			if ($item->getPrimaryImage() && $this->parameters->get('mosaic_resize_enable', false)){
				$width = $this->parameters->get('mosaic_resize_width', 0);
				$height = $this->parameters->get('mosaic_resize_height', 0);
				$item->getPrimaryImage()->resize($width, $height);
			}

			// ordering
			$item->custom_ordering_items = '<div style="display: none;" data-mosaic-order-title="'.$item->getTitle().'" data-mosaic-order-date="'.$item->getDate().'"></div>';

			// tagging
			$tags = $item->getParam('mosaic_item_tags', false);
			$tags = ($tags ? explode(",", $tags) : array());
			$item->tag = $tags;
			$item->custom_tags = "";

			foreach($tags as $tag){
				$cleanName = trim($tag);
				$key = str_replace(' ', '-', str_replace(array("'", '"'), '', $cleanName));
				$name = $this->_camelize($cleanName, true, true);

				$item->custom_tags .= " sprocket-tags-" . $key;

				if (!array_key_exists($key, $this->tagging)){
					$this->tagging[$key] = $name;
				}
			}

			$item->custom_tags = trim($item->custom_tags);

		}
	}

	/**
	 * @return RokSprocket_ItemCollection
	 */
	public function getItems()
	{
		return $this->items;
	}


	/**
	 * @return RokCommon_Composite_Context
	 */
	public function getThemeContent()
	{
		return $this->theme_context;
	}
	/**
	 * @return bool|string
	 */
	public function renderBody()
	{

		$theme_basefile = $this->container[sprintf('roksprocket.layouts.%s.themes.%s.basefile', $this->name, $this->theme)];
		$items = $this->items->slice(0, $this->parameters->get('mosaic_items_per_page', 5));
		$pages = ceil($this->items->count() / count($items));

		// ordering
		$ordering = $this->parameters->get('mosaic_ordering', array('default', 'title', 'date', 'random'));

		// tagging
		$tagging = $this->tagging;

		// article details
		$this->parameters->set('mosaic_article_details', (bool) $this->parameters->get('mosaic_article_details', false));

		return $this->theme_context->load($theme_basefile, array(
		                                                  'layout'    => $this,
		                                                  'items'     => $items,
		                                                  'pages'	  => $pages,
		                                                  'ordering'  => $ordering,
		                                                  'tagging' => $tagging,
		                                                  'parameters'=> $this->parameters
		                                             ));
	}

	/**
	 * Called to render headers that should be included on a per module instance basis
	 */
	public function renderInstanceHeaders()
	{
		RokCommon_Header::addScript($this->theme_context->getUrl('mosaic.js'));
		RokCommon_Header::addStyle($this->theme_context->getUrl('mosaic.css'));

		$items = $this->items->slice(0, $this->parameters->get('mosaic_items_per_page', 5));
		$pages = ceil($this->items->count() / count($items));

		$id						= $this->parameters->get('module_id');
		$settings				= new stdClass();
		$settings->pages 		= $pages;
		$settings->animations	= explode(',', implode(',', (array) $this->parameters->get('mosaic_animations', array('fade', 'scale', 'rotate'))));
		$options				= json_encode($settings);

		$js   = array();
		$js[] = "window.addEvent('domready', function(){";
		$js[] = "	RokSprocket.instances.mosaic.attach(" . $id . ", '" . $options . "');";
		$js[] = "});";
		RokCommon_Header::addInlineScript(implode("\n", $js) . "\n");
	}

	/**
	 * Called to render headers that should be included only once per Layout type used
	 */
	public function renderLayoutHeaders()
	{
		if (!self::$instanceHeadersRendered) {

			$root_assets = RokCommon_Composite::get($this->basePackage . '.assets.js');
			RokCommon_Header::addScript($root_assets->getUrl('moofx.js'));
			RokCommon_Header::addScript($root_assets->getUrl('roksprocket.request.js'));

			$instance   = array();
			$instance[] = "window.addEvent('domready', function(){";
			$instance[] = "		RokSprocket.instances.mosaic = new RokSprocket.Mosaic();";
			$instance[] = "});";

			RokCommon_Header::addInlineScript(implode("\n", $instance)."\n");

			self::$instanceHeadersRendered = true;
		}
	}

	public function _getWords($string, $amount = false)
	{
		if (!$amount) $amount = strlen($string);
		$words = explode(' ', $string, ($amount + 1));
		if(count($words) > $amount) array_pop($words);

		return implode(' ', $words);
	}

	public function _camelize($string, $pascalCase = false, $keepSpaces = false){
		$string = str_replace(array('-', '_'), ' ', $string);
		$string = ucwords($string);

		if (!$keepSpaces) $string = str_replace(' ', '', $string);
		if (!$pascalCase) {
			return lcfirst($string);
		}

		return $string;
	}
}
