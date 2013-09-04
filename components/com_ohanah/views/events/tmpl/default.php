<? defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<style src="media://com_ohanah/v2/pagination.css" />
<?=@helper('behavior.mootools'); ?>

<div class="ohanah">
	<? if (($params->get('loadJQuery') != '0') && (!JFactory::getApplication()->get('jquery'))) : ?>
		<script src="media://com_ohanah/js/jquery.min.js" />
		<? JFactory::getApplication()->set('jquery', true); ?>
	<? endif; ?>
	<script src="media://com_ohanah/js/jquery-ui.custom.min.js" />
	<link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
	<style src="media://com_ohanah/css/screen.css" />
	
	<?= @helper('module.injector', array('title' => '', 'placeholder' => 'ohanah-list-events-1', 'position' => $params->get('listEventsModulePosition1'))) ?>
	<?= @helper('module.injector', array('title' => '', 'placeholder' => 'ohanah-list-events-2', 'position' => $params->get('listEventsModulePosition2'))) ?>
	<?= @helper('module.injector', array('title' => '', 'placeholder' => 'ohanah-list-events-3', 'position' => $params->get('listEventsModulePosition3'))) ?>	
	
	<? if ($this->getView()->getModel()->ohanah_venue_id) : ?>
		<?= @helper('module.injector', array('title' => '', 'placeholder' => 'ohanah-single-venue-1', 'position' => $params->get('singleVenueModulePosition1'))) ?>
		<?= @helper('module.injector', array('title' => '', 'placeholder' => 'ohanah-single-venue-2', 'position' => $params->get('singleVenueModulePosition2'))) ?>
		<?= @helper('module.injector', array('title' => '', 'placeholder' => 'ohanah-single-venue-3', 'position' => $params->get('singleVenueModulePosition3'))) ?>
	<? endif ?>

	<? if ($this->getView()->getModel()->ohanah_category_id) : ?>
		<?= @helper('module.injector', array('title' => '', 'placeholder' => 'ohanah-single-category-1', 'position' => $params->get('singleCategoryModulePosition1'))) ?>
		<?= @helper('module.injector', array('title' => '', 'placeholder' => 'ohanah-single-category-2', 'position' => $params->get('singleCategoryModulePosition2'))) ?>
		<?= @helper('module.injector', array('title' => '', 'placeholder' => 'ohanah-single-category-3', 'position' => $params->get('singleCategoryModulePosition3'))) ?>		
	<? endif ?>

	<? if (count($events)) : ?>
		<? if ($pageParameters->get('displayStyle') == 'ul_list') : ?>
			<ul>
				<? foreach ($events as $event) : ?>
					<? if ($event->enabled) : ?>
						<li><a href="<?=@route('view=event&id='.$event->id)?>"><?=$event->title?></a></li>
					<? endif; ?>
				<? endforeach; ?>
			</ul>
		<? else : ?>
			<? foreach ($events as $event) : ?>
				<? if ($event->enabled) : ?>
					<?= @template('com://site/ohanah.view.event.default_header', array('event' => $event, 'params' => $params)); ?>
					<br />
					<hr />
				<? endif; ?>
				<br />
			<? endforeach; ?>	
		<? endif; ?>
			
		<? if ($pageParameters->get('usePagination', 1)) : ?>
			<?= @helper('paginator.pagination', array('total' => $total)) ?>
		<? endif ?>
	
	<? else : ?>
		<h3><?=@text('OHANAH_SORRY_NO_EVENTS_MATCH_YOUR_SEARCH_CRITERIA')?></h3>
	<? endif ?>
</div>