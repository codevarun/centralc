<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<div class="ohanah module<?php echo $params->get( 'moduleclass_sfx' ) ?>" itemscope itemtype="http://schema.org/EventVenue">
	<? if ($event->latitude && $event->longitude) : ?>
		<div id="event_main_map_wrapper">
			<? $width = $params->get('mapWidth'); if (!$width) $width = 200; ?>
			<? $height = $params->get('mapHeight'); if (!$height) $height = 150; ?>
			<div id="event_main_map">
				<img itemprop="maps" style="width: <?=$width?>px; height: <?=$height?>px; border: 1px solid #CCCCCC; border-radius: 3px 3px 3px 3px; margin-bottom:5px" src="http://maps.google.com/maps/api/staticmap?zoom=15&size=<?=$width?>x<?=$height?><? if (substr($_SERVER['HTTP_HOST'], 0, 9) != 'localhost') echo '&markers=icon:http://'.$_SERVER['HTTP_HOST'].str_replace('/administrator', '', KRequest::base()).'/media/com_ohanah/images/ohapp_mapmarker.png'; else echo '&markers=color:blue'; ?>|<?=$event->latitude?>,<?=$event->longitude?>&sensor=false" />
			</div>
		</div>
		<div class="event_main_location_description">
			<h3 itemprop="name"><?=$this->getService('com://admin/ohanah.model.venues')->id($event->ohanah_venue_id)->getItem()->title?></h3>
			<p itemprop="address"><?=$event->address?><br /><a target="blank" href="http://maps.google.com/maps?f=d&daddr=<?=$event->latitude ?>,<?=$event->longitude ?>(<?=$event->address?>)"><?=@text('OHANAH_GET_DIRECTIONS')?></a></p>
		</div>
	<? endif; ?>
</div>