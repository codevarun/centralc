<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<div class="ohanah module<?php echo $params->get( 'moduleclass_sfx' ) ?>">
	<? $images = @service('com://admin/ohanah.model.attachments')->set('target_type', 'event')->set('target_id', $event->id)->getList() ?>
 
 	<? if (count($images)) : ?>
 		<? foreach ($images as $image) : ?>
			<? if ($image->name != $event->picture) : ?>
				<a class="ohanah_modal" href="media://com_ohanah/attachments/<?=$image->name?>"><div class="event-photos" style="background: url('media://com_ohanah/attachments_thumbs/<?=$image->name?>'); background-size: 100% 100%; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; float: left;"></div></a>
			<? endif ?>
		<? endforeach ?>
	<? endif ?>
</div>