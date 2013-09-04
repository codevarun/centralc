<?php defined('_JEXEC') or die('Restricted access'); ?>
<div class="ohanah module<?php echo $params->get( 'moduleclass_sfx' ) ?>">
	<? $images = @service('com://admin/ohanah.model.attachments')->set('target_type', 'category')->set('target_id', $category->id)->getList() ?>
 
 	<? if (count($images)) : ?>
	 	<script src="media://com_ohanah/jquery-lightbox-0.5/js/jquery.lightbox-0.5.min.js" />
		<style src="media://com_ohanah/jquery-lightbox-0.5/css/jquery.lightbox-0.5.css" />

 		<? foreach ($images as $image) : ?>
			<a class="ohanah_modal" href="media://com_ohanah/attachments/<?=$image->name?>"><div class="event-photos" style="background: url('media://com_ohanah/attachments_thumbs/<?=$image->name?>');"></div></a>
		<? endforeach ?>
	<? endif ?>
</div>