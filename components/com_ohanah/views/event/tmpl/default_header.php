<? defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<? jimport('joomla.html.parameter'); ?>

<? $params = JComponentHelper::getParams('com_ohanah') ?>

<?
if (isset($module)) $isModule = true; else $isModule = false;
if (!$isModule && (KRequest::get('get.view', 'string') == 'event')) $isSingle = true; else $isSingle = false;
if (!$isModule && (KRequest::get('get.view', 'string') == 'registration')) $isRegistration = true; else $isRegistration = false;
if (!$isModule && (KRequest::get('get.view', 'string') == 'events')) $isList = true; else $isList = false;

if (($isRegistration && $params->get('showLinkToCategoryInRegistration', 1)) || ($isList && $params->get('showLinkToCategoryInList', 1)) || ($isSingle && $params->get('showLinkToCategoryInSingle', 1)) || ($isModule && $params->get('showLinkToCategoryInModule', 1))) { 	$showLinkToCategory = true; } else $showLinkToCategory = false; 
if (($isRegistration && $params->get('showLinkToVenueInRegistration', 1)) || ($isList && $params->get('showLinkToVenueInList', 1)) || ($isSingle && $params->get('showLinkToVenueInSingle', 1)) || ($isModule && $params->get('showLinkToVenueInModule', 1))) { $showLinkToVenue = true; } else $showLinkToVenue = false; 
if (($isRegistration && $params->get('showLinkToRecurringSetInRegistration', 1)) || ($isList && $params->get('showLinkToRecurringSetInList', 1)) || ($isSingle && $params->get('showLinkToRecurringSetInSingle', 1)) || ($isModule && $params->get('showLinkToRecurringSetInModule', 1))) { $showLinkToRecurringSet = true; } else $showLinkToRecurringSet = false; 
if (($isRegistration && $params->get('showLinkToSaveToCalInRegistration', 1)) || ($isList && $params->get('showLinkToSaveToCalInList', 1)) || ($isSingle && $params->get('showLinkToSaveToCalInSingle', 1)) || ($isModule && $params->get('showLinkToSaveToCalInModule', 1))) { $showLinkToSaveToCal = true; } else $showLinkToSaveToCal = false; 
if (($isRegistration && $params->get('showCostInfoInRegistration', 1)) || ($isList && $params->get('showCostInfoInList', 1)) || ($isSingle && $params->get('showCostInfoInSingle', 1)) || ($isModule && $params->get('showCostInfoInModule', 1))) { $showCostInfo = true; } else $showCostInfo = false; 
if (($isRegistration && $params->get('showPlacesLeftInRegistration', 1)) || ($isList && $params->get('showPlacesLeftInList', 1)) || ($isSingle && $params->get('showPlacesLeftInSingle', 1)) || ($isModule && $params->get('showPlacesLeftInModule', 1))) { $showPlacesLeft = true; } else $showPlacesLeft = false; 
if (($isRegistration && $params->get('showEventPictureInRegistration', 1)) || ($isList && $params->get('showEventPictureInList', 1)) || ($isSingle && $params->get('showEventPictureInSingle', 1)) || ($isModule && $params->get('showEventPictureInModule', 1))) { $showEventPicture = true; } else { $showEventPicture = false;}
if (($isRegistration && $params->get('showEventFullDescriptionInRegistration', 0)) || ($isList && $params->get('showEventFullDescriptionInList', 0)) || ($isSingle && $params->get('showEventFullDescriptionInSingle', 1)) || ($isModule && $params->get('showEventFullDescriptionInModule', 0))) { $showEventFullDescription = true; } else $showEventFullDescription = false; 
if (($isRegistration && $params->get('showEventDescriptionSnippetInRegistration', 1)) || ($isList && $params->get('showEventDescriptionSnippetInList', 1)) || ($isSingle && $params->get('showEventDescriptionSnippetInSingle', 0)) || ($isModule && $params->get('showEventDescriptionSnippetInModule', 1))) { $showEventDescriptionSnippet = true; } else $showEventDescriptionSnippet = false; 
if (($isRegistration && $params->get('showEventDateInRegistration', 1)) || ($isList && $params->get('showEventDateInList', 1)) || ($isSingle && $params->get('showEventDateInSingle', 1)) || ($isModule && $params->get('showEventDateInModule', 1))) { $showEventDate = true; } else $showEventDate = false; 
if (($isRegistration && $params->get('showEventAddressInRegistration', 1)) || ($isList && $params->get('showEventAddressInList', 1)) || ($isSingle && $params->get('showEventAddressInSingle', 1)) || ($isModule && $params->get('showEventAddressInModule', 1))) { $showEventAddress = true; } else $showEventAddress = false; 
if (($isRegistration && $params->get('showBigDateBadgeInRegistration', 0)) || ($isList && $params->get('showBigDateBadgeInList', 0)) || ($isSingle && $params->get('showBigDateBadgeInSingle', 0)) || ($isModule && $params->get('showBigDateBadgeInModule', 0))) { $showBigDateBadge = true; } else $showBigDateBadge = false; 
if (($isRegistration && $params->get('showReadMoreInRegistration', 0)) || ($isList && $params->get('showReadMoreInList', 1)) || ($isSingle && $params->get('showReadMoreInSingle', 1)) || ($isModule && $params->get('showReadMoreInModule', 1))) { $showReadMoreLink = true; } else $showReadMoreLink = false; 
if (($isRegistration && $params->get('showTimeInRegistration', 1)) || ($isList && $params->get('showTimeInList', 0)) || ($isSingle && $params->get('showTimeInSingle', 0)) || ($isModule && $params->get('showTimeInModule', 0))) { $showTime = true; } else $showTime = false; 

?>

<?

$pageparameters =& JFactory::getApplication()->getPageParameters();

if (!$event->id && $id = $pageparameters->get('id')) {
	$event = $this->getService('com://site/ohanah.model.events')->set('id', $id)->getItem();
}
?>

<script src="media://com_ohanah/jquery-lightbox-0.5/js/jquery.lightbox-0.5.min.js" />
<style src="media://com_ohanah/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" />

<div class="event_detail_container" itemscope itemtype="http://schema.org/Event">
	<? if ($event->picture && $showEventPicture) : ?>
		<a class="ohanah_modal" href="media://com_ohanah/attachments/<?=$event->picture?>"  itemprop="image"><div class="event-photos" style="background: url('media://com_ohanah/attachments_thumbs/<?=$event->picture?>'); background-size: 100% 100%"></div></a>
	<? endif ?>

	<? if ($showBigDateBadge) : ?>
		<div class="event_date_flyer_container">
			<div class="event_date"  id="event_date_day">	
				<div class="event_date_day">
					<?= strftime('%d', strtotime($event->date)) ?>
				</div>
				<div class="event_date_month">
					<?= JText::_(substr(strftime('%B', strtotime($event->date)),0,3)) ?>
				</div>
				<div class="event_date_year">
					<?= strftime('%Y', strtotime($event->date)) ?>
				</div>
			</div>
		</div>
	<? endif ?>

	<div class="event_detail_title">
		<? if ($params->get('itemid')) $itemid = '&Itemid='.$params->get('itemid'); else $itemid = ''; ?>
		<? if (!$isSingle && !$isRegistration) : ?>
			<h2 itemprop="name"><a href="<?=@route('option=com_ohanah&view=event&id='.$event->id.$itemid)?>" itemprop="url"><?=$event->title?></a></h2>
		<? endif ?>
	</div>

	<? if ($showEventDate || $showTime) : ?>
	<div style="display:inline" class="event_detail_time">
		<div class="date_icon"></div>
		<h3 style="display:inline">
			<?
			if (JFactory::getApplication()->getPageParameters('com_ohanah')->get('timeFormat') == '1') { //12 hours
				$start_time = date("g:i a", strtotime($event->start_time));	
				$end_time = date("g:i a", strtotime($event->end_time));	
			} else {
				$start_time = date("H:i", strtotime($event->start_time));	
				$end_time = date("H:i", strtotime($event->end_time));	
			}
			?>

			<? if ($showEventDate) : ?>
				<span itemprop="startDate">
					<?= @helper('date.format', array('date' => $event->date, 'format' => '%d', 'gmt_offset' => '0'));?>
					<?= JText::_(@helper('date.format', array('date' => $event->date, 'format' => '%B', 'gmt_offset' => '0')));?>
					<?=@helper('date.format', array('date' => $event->date, 'format' => '%Y', 'gmt_offset' => '0'));?>
				</span>
			<? endif ?>

			<? if ($showTime) : ?>
				<?=$start_time?>
			<? endif ?>

			<? if ($event->end_time_enabled) : ?>
				<? if (substr($event->date, 0, 10) == substr($event->end_date, 0, 10)) : ?>
					<? if ($showTime) : ?>
						<? if ($start_time != $end_time) : ?>
							- <?=$end_time?>
						<? endif ?>
					<? endif ?>
				<? else : ?>
					-
					<? if ($showEventDate) : ?>
						<span itemprop="endDate">
							<?= @helper('date.format', array('date' => $event->end_date, 'format' => '%d', 'gmt_offset' => '0'));?>
							<?= JText::_(@helper('date.format', array('date' => $event->end_date, 'format' => '%B', 'gmt_offset' => '0')));?>
							<?=@helper('date.format', array('date' => $event->end_date, 'format' => '%Y', 'gmt_offset' => '0'));?>
						</span>
					<? endif ?>
					<? if ($showTime) : ?>
						<?=$end_time?>
					<? endif ?>
				<? endif ?>
			<? endif ?>
		</h3>
	</div>
	<? endif ?>

	<? if ($showLinkToSaveToCal) : ?>
		<span class="save_to_cal">
			<? $url = @route('option=com_ohanah&view=event&id='.$event->id); ?>
			<? if (strpos($url, '?')) $url .= '&format=ics'; else $url .= '?format=ics'; ?>
			<h3 style="display:inline">(<a href="<?=$url?>"><?=@text('OHANAH_SAVE_TO_CAL')?></a>)</h3>
		</span>
	<? endif ?>

	<? if ($showEventAddress) : ?>
	<div class="event_detail_location">
		<? $event_place_style = $params->get('event_place_style') ?>
		<div class="location_icon"></div>

		<h3 itemprop="location">
			<? if (!$event->ohanah_venue_id && !$event->geolocated_country && !$event->geolocated_city) : ?>
				TBA
			<? else : ?>
				<? if ($event_place_style == 'venue') : ?>
					<?=@service('com://site/ohanah.model.venues')->id($event->ohanah_venue_id)->getItem()->title?>
				<? elseif ($event_place_style == 'venue_and_city') : ?>
					<?=@service('com://site/ohanah.model.venues')->id($event->ohanah_venue_id)->getItem()->title?><? if ($event->geolocated_city) : ?>, <?=$event->geolocated_city?><? endif ?>
				<? elseif ($event_place_style == 'address') : ?>
					<?=$event->address?>
				<? elseif ($event_place_style == 'venue_and_address') : ?>
					<?=@service('com://site/ohanah.model.venues')->id($event->ohanah_venue_id)->getItem()->title?> @ <?=$event->address?>
				<? elseif ($event_place_style == 'city_and_country') : ?>
					<? if ($event->geolocated_city) : ?><?=$event->geolocated_city?><?endif?><? if ($event->geolocated_country && $event->geolocated_city) : ?>, <?endif?><? if ($event->geolocated_country) : ?><?=$event->geolocated_country?><? endif ?>
				<? elseif ($event_place_style == 'city_and_state') : ?>
					<? if ($event->geolocated_city) : ?><?=$event->geolocated_city?><?endif?><? if ($event->geolocated_state && $event->geolocated_city) : ?>, <?endif?><? if ($event->geolocated_state) : ?><?=$event->geolocated_state?><? endif ?>
				<? elseif ($event_place_style == 'city_state_and_country') : ?>
					<? if ($event->geolocated_city) : ?><?=$event->geolocated_city?><?endif?><? if ($event->geolocated_state && $event->geolocated_city) : ?>, <?=$event->geolocated_state?><?endif?><? if ($event->geolocated_country && ($event->geolocated_city || $event->geolocated_state)) : ?>, <?endif?><? if ($event->geolocated_country) : ?><?=$event->geolocated_country?><? endif ?>
				<? endif ?>
			<? endif ?>
		</h3>
	</div>
	<? endif ?>


	<? if ($isSingle) : ?>
		<? if ($showBigDateBadge) : ?><div class="date-badge-spacer"><br /><br /></div><? endif ?>
		<? if ($params->get('showButtonTwitter') || $params->get('showButtonGoogle') || $params->get('showButtonFacebook')) : ?><div class="ohanah-social-buttons-wrapper"><? endif ?>
			<? if ($params->get('showButtonTwitter')) : ?>
				<div style="float: left; ">
					<a href="https://twitter.com/share" class="twitter-share-button" data-count="none">Tweet</a>
					<script src="http://platform.twitter.com/widgets.js" />
				</div>
			<? endif ?>
			<? if ($params->get('showButtonGoogle')) : ?>
				<div style="float: left; margin-left:10px">
					<g:plusone size="medium" annotation="none"></g:plusone>
					<script type="text/javascript">
					  (function() {
					    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
					    po.src = 'https://apis.google.com/js/plusone.js';
					    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
					  })();
					</script>
				</div>
			<? endif ?>
			<? if ($params->get('showButtonFacebook')) : ?>
				<? 
				 	$config =& JFactory::getConfig();
					$language = $config->getValue('config.language');
	     			
	    			$languagesSupportedByFacebook = array('en-GB', 'pt-BR', 'sq-AL', 'ar-DZ', 'hy-HY', 'be-BY', 'bg-BG', 'ca-ES', 'zh-CN', 'hr-HR', 'cs-CZ', 'da-DK', 'nl-NL', 'eo-EO', 'et-EE', 'fi-FI', 'fr-FR', 'es-GL', 'de-DE', 'el-GR', 'iw-IL', 'hi-IN', 'hu-HU', 'is-IS', 'in-ID', 'ga-IE', 'it-IT', 'ja-JP', 'ko-KR', 'lv-LV', 'lt-LT', 'mk-MK', 'ms-MY', 'mt-MT', 'nb-NO', 'nn-NO', 'fa-FA', 'pl-PL', 'pt-PT', 'ro-RO', 'ru-RU', 'sr-RS', 'sk-SK', 'sl-SI', 'es-ES', 'sv-SE', 'th-TH', 'tr-TR', 'uk-UA', 'vi-VN');
	     			
	    			if (!in_array($language, $languagesSupportedByFacebook)) {
	    				$language = 'en-GB';
	     			}
	     		?>

				<div style="float: left; margin-left:10px">
					<div id="fb-root"></div>
					<script>(function(d, s, id) {
					  var js, fjs = d.getElementsByTagName(s)[0];
					  if (d.getElementById(id)) {return;}
					  js = d.createElement(s); js.id = id;
					  js.src = "//connect.facebook.net/<?=str_replace('-', '_', $language)?>/all.js#xfbml=1";
					  fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));</script>

					<div class="fb-like" data-send="false" data-layout="button_count" data-width="40" data-show-faces="true"></div>
				</div>
			<? endif ?>	

		<? if ($params->get('showButtonTwitter') || $params->get('showButtonGoogle') || $params->get('showButtonFacebook')) : ?></div> <!-- ohanah-social-buttons-wrapper --><? endif ?>
	<? endif ?>

	<? if ($showEventDescriptionSnippet) : ?>
		<? $desc = $event->description; ?>
		<? $desc = preg_replace("/\{[^\)]+\}/","", $desc) ?>
		<? if (extension_loaded('mbstring')) : ?>
			<? $desc = mb_substr(strip_tags($desc, '<br>'), 0, 200)?> <? if (mb_strlen($desc) == 200) $desc .= '...'; ?>
		<? else : ?>
			<? $desc = substr(strip_tags($desc, '<br>'), 0, 200)?> <? if (strlen($desc) == 200) $desc .= '...'; ?>
		<? endif ?>
		<div itemprop="description" class="ohanah-event-short-description">
		<?=$desc?>
		</div>
	<? endif ?>

	<? if ($showEventFullDescription) : ?>
			<?
		$description = $event->description;

		// Create temporary article
   		$item =& JTable::getInstance('content');
   		$item->parameters = new JParameter('');
   		$item->text = '<!--{emailcloak=off}-->'.$description;

		$joomlaVersion = JVersion::isCompatible('1.6.0') ? '1.6' : '1.5';
		if ($joomlaVersion == '1.5') { 
			$results = JFactory::getApplication()->triggerEvent('onPrepareContent', array (&$item, &$params, 1));
		} else {
			$dispatcher	= JDispatcher::getInstance();
			JPluginHelper::importPlugin('content');
			$results = $dispatcher->trigger('onContentPrepare', array ('com_content.article', &$item, &$params, 1));
		}	
   		$description = $item->text;		
		?>
		<div style="display:none"><span itemprop="name"><?=$event->title?></span></div>
		<div itemprop="description" class="ohanah-event-full-description">
			<?=$description?>
		</div>
	<? endif ?>

	<div class="event-spacer"><br /><br /></div>
	<div id="event-container-info">

		<? if (!$isRegistration) : ?>
			<span style="float: right; padding-left:12px">
				<? if ($isSingle) : ?>
					<? if ($event->who_can_register == '0' || ($event->who_can_register == '1' && !JFactory::getUser()->guest)) : ?>
						<? 
						if ($event->get('payment_gateway') != 'none' && $event->ticket_cost) $text = @text('OHANAH_BUY_TICKETS');
						else $text = @text('OHANAH_REGISTER');
						?>

						<? if ($event->registration_system == 'custom') : ?>
							<? if ($event->custom_registration_url) : ?>
								<? $date = new KDate(); ?>
								<? if ($event->isPast() || (($event->close_registration_day != '0000-00-00') && ($event->close_registration_day != '1970-01-01') && ($date->format('%Y-%m-%d') > $event->close_registration_day))) : ?>
								<? else : ?>
									<?= @helper('com://site/ohanah.template.helper.button.button', array('type' => 'link', 'text' => $text, 'link' => $event->custom_registration_url)); ?>
								<? endif ?>
							<? endif ?>
						<? else : ?>
							<? if (!$event->limit_number_of_attendees or $event->countAttendees() < $event->attendees_limit) : ?>
								<? $date = new KDate(); ?>
								<? if ($event->isPast() || (($event->close_registration_day != '0000-00-00') && ($event->close_registration_day != '1970-01-01') && ($date->format('%Y-%m-%d') > $event->close_registration_day))) : ?>
								<? else : ?>
									<?= @helper('com://site/ohanah.template.helper.button.button', array('type' => 'link', 'text' => $text, 'link' => @route('option=com_ohanah&view=registration&ohanah_event_id='.$event->id.$itemid))); ?>
								<? endif ?>
							<? else : ?>
								&nbsp;&nbsp;|&nbsp;&nbsp;<?=@text('OHANAH_TICKETS_SOLD_OUT')?>
							<? endif; ?>
						<? endif ?>
					<? endif ?>
				<? elseif ($isList || $isModule) : ?>
					<? if ($showReadMoreLink) : ?>
						<?= @helper('com://site/ohanah.template.helper.button.button', array('type' => 'link', 'text' => @text('OHANAH_READ_MORE'), 'link' => @route('option=com_ohanah&view=event&id='.$event->id.$itemid))); ?>
					<? endif ?>
				<? endif ?>
			</span>
		<? elseif ($isModule) : ?>
			<? if ($showReadMoreLink) : ?>
				<?= @helper('com://site/ohanah.template.helper.button.button', array('type' => 'link', 'text' => @text('OHANAH_READ_MORE'), 'link' => @route('option=com_ohanah&view=event&id='.$event->id.$itemid))); ?>
			<? endif ?>
		<? endif ?>

		<? if (!$event->isPast()) : ?>
			<? if ($showPlacesLeft) : ?>
				<? if ($event->limit_number_of_attendees) : ?>
					<span class="ohanah-event-places-left" style="float: right"><?=@text('OHANAH_PLACES_LEFT')?>: <? $diff = ($event->attendees_limit - $event->countAttendees()); if ($diff < 0) $diff = 0; echo $diff ?></span>
					<? if ($showCostInfo) : ?><span class="ohanah-event-places-left" style="float: right">&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;</span><? endif ?>
				<? endif ?>				
			<? endif ?>
		
			<? if ($showCostInfo) : ?>
				<span class="ohanah-event-ticket-cost" style="float: right"><?=@text('OHANAH_TICKET_COST')?>: <? if ($event->ticket_cost) : ?><?=$event->ticket_cost?> <?=$event->payment_currency?><? else : ?><?=@text('OHANAH_FREE')?><? endif ?></span><div class="ticket_icon" style="float: right"></div>
			<? endif ?>
		<? endif ?>

		<? if ($showLinkToCategory) : ?>
			<span class="ohanah-event-category-link" style="float: left"><a href="<?=@route('option=com_ohanah&view=events&ohanah_category_id='.$event->ohanah_category_id.'&ohanah_venue_id=&filterEvents=notpast'.$itemid)?>"><?=@service('com://site/ohanah.model.categories')->id($event->ohanah_category_id)->getItem()->title?></a></span>
		<? endif ?>

		<? if ($showLinkToVenue) : ?>
			<? if ($event->ohanah_venue_id) : ?><span class="ohanah-event-venue-link" style="float: left"><? if ($showLinkToCategory) : ?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<? endif ?>@ <a href="<?=@route('option=com_ohanah&view=events&ohanah_venue_id='.$event->ohanah_venue_id.'&ohanah_category_id=&filterEvents=notpast'.$itemid)?>"><?=@service('com://site/ohanah.model.venues')->id($event->ohanah_venue_id)->getItem()->title?></a></span><? endif ?>
		<? endif ?>

		<? if ($showLinkToRecurringSet) : ?>
			<? if ($event->isRecurring()) : ?><span class="ohanah-event-recurrent-link"><? if ($showLinkToCategory || $showLinkToVenue) : ?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<? endif ?></span>
				<? if ($event->recurringParent) : ?>
					<span class="ohanah-event-recurrent-link"><a href="<?=@route('option=com_ohanah&view=events&recurringParent='.$event->recurringParent.$itemid)?>"><?=@text('OHANAH_RECURRING_SET')?></a><span>
				<? else : ?>
					<span class="ohanah-event-recurrent-link"><a href="<?=@route('option=com_ohanah&view=events&recurringParent='.$event->id.$itemid)?>"><?=@text('OHANAH_RECURRING_SET')?></a><span>
				<? endif ?>
			<? endif ?>
		<? endif ?>
	</div>
	<div class="event-spacer"><br /><br /></div>
</div>

<?

/* Facebook integration 
	If we are in single event view we will add Open Graph tags.
	If JFBConnect plugin is present then we will add it's {tags}, thus not duplicating og:tags

*/
	// global docs
	if ($isSingle) {
		
		// check for JFBConnect plugin
		$jfbc = false;
		if (JPluginHelper::isEnabled('system', 'jfbcsystem')) $jfbc = true;

		$doc =& JFactory::getDocument();

		// making description 
		// shorten it to 305 chars since facebook will pull 300, linked in 225 and google plus 200 so it's enought

		$fbdesc = $event->description;
		$fbdesc = preg_replace("/\{[^\)]+\}/","", $fbdesc);
		if (extension_loaded('mbstring')) {
			$fbdesc = mb_substr(strip_tags($fbdesc, "<br>"), 0, 305);
		} else {
			$fbdesc = substr(strip_tags($fbdesc, "<br>"), 0, 305);
		}
		$newLines = Array("<br>", "<br />", "<br >");
		$fbdesc = str_replace($newLines, " ", $fbdesc);
		// we must clear " " since it will break the code
		$fbdesc = preg_replace('/"/',"", $fbdesc);
		$fbdesc = trim($fbdesc);
		if (!$jfbc) {
			// adding type as article (no event unfortunatelly)
			$doc->addCustomTag( '<meta property="og:type" content="article" />');

			// adding current url as url
			$u =& JURI::getInstance();
			$doc->addCustomTag( '<meta property="og:url" content="'.$u->toString().'" />');

			// adding locale
			$lang = JFactory::getLanguage();
      $locale = $lang->getTag();
      $locale = str_replace("-", "_", $locale);
			$doc->addCustomTag( '<meta property="og:locale" content="'.$locale.'" />');			

			// title
			$doc->addCustomTag( '<meta property="og:title" content="'.$event->title.'" />' );
			
			// image (if any); path must be absolute!
			if ($event->picture && $showEventPicture) {
				$doc->addCustomTag( '<meta property="og:image" content="'.JURI::base().'media/com_ohanah/attachments/'.$event->picture.'" />' );
			}

			// description
			$doc->addCustomTag( '<meta property="og:description" content="'.$fbdesc.'" />' );
		
		} else { // we have JFBConnect plugin so we will use it's tags
			// no need for type, url or locale, jfbc is doing it automatically
			echo "{JFBCGraph title=".$event->title."}";
			echo "{JFBCGraph image=".JURI::base().'media/com_ohanah/attachments/'.$event->picture."}";
			// since JFBConnect doesn't like multiline tags, we must strip them out
			$fbdesc = trim($fbdesc);
			$fbdesc = str_replace("\n", " ", $fbdesc);
			$fbdesc = str_replace("\r", "", $fbdesc);
			echo "{JFBCGraph description=".$fbdesc."}";
		}
	}
/* end of facebook integration */
?>