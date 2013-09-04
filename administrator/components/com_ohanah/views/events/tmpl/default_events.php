<? (defined('_JEXEC') && defined('KOOWA')) or die('Restricted access'); ?>

<tr>
	<th class="first">&nbsp;</th>
	<th>&nbsp;</th>
	<th><input type='checkbox' id='toggle' /></th>
	<th><?= @helper('grid.sort', array('column' => 'title')); ?></th>
	<th><?= @helper('grid.sort', array('column' => 'date')); ?></th>
	<th><?= @helper('grid.sort', array('column' => 'ohanah_category_id', 'title' => 'Category')); ?></th>
	<th><?= @helper('grid.sort', array('column' => 'ohanah_venue_id', 'title' => 'Venue')); ?></th>
	<th><?=@text('OHANAH_ATTENDEES')?></th>
	<? if (KRequest::get('get.frontend_submitted', 'string')) : ?><th><?=@text('OHANAH_CREATED_BY')?></th><? endif ?>
	<th><?= @helper('grid.sort', array('column' => 'enabled', 'title' => 'P')); ?></th>
	<th><?= @helper('grid.sort', array('column' => 'featured', 'title' => 'F')); ?></th>
</tr>

<? $i = 0; ?>

<? if ($recurring_id = KRequest::get('get.recurringParent', 'int')) : ?>
	<? $event = @service('com://admin/ohanah.model.events')->id($recurring_id)->getItem() ?>
	<?= @template('default_event', array('event' => $event, 'i' => $i++)); ?>
<? endif ?>

<? foreach ($events as $event) : ?>
	<?= @template('default_event', array('event' => $event, 'i' => $i++)); ?>
<? endforeach ?>