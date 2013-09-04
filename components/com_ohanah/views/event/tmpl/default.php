<? defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<?=@helper('behavior.mootools'); ?>
<script src="media://lib_koowa/js/koowa.js" />

<div class="ohanah event-<?=$event->id?>" >
	<?= @helper('module.injector', array('title' => '', 'placeholder' => 'ohanah-single-event-1', 'position' => $params->get('singleEventModulePosition1'))) ?>
	<?= @helper('module.injector', array('title' => '', 'placeholder' => 'ohanah-single-event-2', 'position' => $params->get('singleEventModulePosition2'))) ?>
	<?= @helper('module.injector', array('title' => '', 'placeholder' => 'ohanah-single-event-3', 'position' => $params->get('singleEventModulePosition3'))) ?>

	<? if (($params->get('loadJQuery') != '0') && (!JFactory::getApplication()->get('jquery'))) : ?>
		<script src="media://com_ohanah/js/jquery.min.js" />
		<? JFactory::getApplication()->set('jquery', true); ?>
	<? endif; ?>

	<script src="media://com_ohanah/js/jquery-ui.custom.min.js" />
	<style src="media://com_ohanah/css/jquery-ui.css" />
	<style src="media://com_ohanah/css/screen.css" />

	<?= @template('default_header', array('event' => $event)); ?>
	
	<? if ($params->get('enableComments')) : ?>
		<? if ($params->get('useFacebookComments')) : ?>
			<? 
			 	$config =& JFactory::getConfig();
				$language = $config->getValue('config.language');

    			$languagesSupportedByFacebook = array('en-GB', 'pt-BR', 'sq-AL', 'ar-DZ', 'hy-HY', 'be-BY', 'bg-BG', 'ca-ES', 'zh-CN', 'hr-HR', 'cs-CZ', 'da-DK', 'nl-NL', 'eo-EO', 'et-EE', 'fi-FI', 'fr-FR', 'es-GL', 'de-DE', 'el-GR', 'iw-IL', 'hi-IN', 'hu-HU', 'is-IS', 'in-ID', 'ga-IE', 'it-IT', 'ja-JP', 'ko-KR', 'lv-LV', 'lt-LT', 'mk-MK', 'ms-MY', 'mt-MT', 'nb-NO', 'nn-NO', 'fa-FA', 'pl-PL', 'pt-PT', 'ro-RO', 'ru-RU', 'sr-RS', 'sk-SK', 'sl-SI', 'es-ES', 'sv-SE', 'th-TH', 'tr-TR', 'uk-UA', 'vi-VN');
     			
    			if (!in_array($language, $languagesSupportedByFacebook)) {
    				$language = 'en-GB';
     			}
     		?>
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/<?=str_replace('-', '_', $language)?>/all.js#xfbml=1";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>

			<? if (JComponentHelper::getParams('com_ohanah')->get('itemid')) $itemid = '&Itemid='.JComponentHelper::getParams('com_ohanah')->get('itemid'); else $itemid = ''; ?>
			<? $url = 'http://'.$_SERVER['HTTP_HOST'].JRoute::_('index.php?option=com_ohanah&view=event&id='.$this->getView()->getModel()->getItem()->id.$itemid); ?>

			<div class="fb-comments" data-href="<?=$url?>" data-num-posts="2" data-width="470"></div>
		<? else : ?>
			<?= html_entity_decode($params->get('commentsCode')); ?>
		<? endif ?>
	<? endif ?>
</div>