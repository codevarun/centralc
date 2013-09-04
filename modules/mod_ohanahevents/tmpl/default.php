<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<div class="ohanah module<?php echo $params->get( 'moduleclass_sfx' ) ?>">
	<? if (JComponentHelper::getParams('com_ohanah')->get('itemid')) $itemid = '&Itemid='.JComponentHelper::getParams('com_ohanah')->get('itemid'); else $itemid = ''; ?>
	
	<? if (($params->get('loadJQuery') != '0') && (!JFactory::getApplication()->get('jquery'))) : ?>
		<script src="media://com_ohanah/js/jquery.min.js" />
		<? JFactory::getApplication()->set('jquery', true); ?>
	<? endif; ?>

	<? if ($displayStyle == 'ul_list') : ?>
		<ul>
			<? foreach ($events as $event) : ?>
				<li><a href="<?=@route('option=com_ohanah&view=event&id='.$event->id.$itemid)?>"><?=$event->title?></a></li>
			<? endforeach; ?>
		</ul>
	<? else : ?>		
		<? foreach ($events as $event) : ?>
			<?= @template('com://site/ohanah.view.event.default_header', array('event' => $event, 'format' => 'html', 'module' => 1)); ?>	
		<? endforeach; ?>
	<? endif; ?>
</div>