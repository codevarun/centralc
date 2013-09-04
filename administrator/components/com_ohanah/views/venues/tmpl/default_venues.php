<? (defined('_JEXEC') && defined('KOOWA')) or die('Restricted access'); ?>

<tr>
	<th class="first">&nbsp;</th>
	<th><input type='checkbox' id='toggle' /></th>
	<th><?= @helper('grid.sort', array('column' => 'title', 'title' => 'OHANAH_NAME')); ?></th>
	<th><?= @helper('grid.sort', array('column' => 'address', 'title' => 'OHANAH_ADDRESS')); ?></th>
	<th><?= @helper('grid.sort', array('column' => 'geolocated_city', 'title' => 'OHANAH_CITY')); ?></th>
	<th><?= @helper('grid.sort', array('column' => 'geolocated_country', 'title' => 'OHANAH_COUNTRY')); ?></th>
	<th><?=@text('EVENTS')?></th>
	<th><?= @helper('grid.sort', array('column' => 'enabled', 'title' => 'P')); ?></th>
</tr>

<? $i = 0; ?>
<? foreach ($venues as $venue) : ?>
	<tr class="<? if ($i++ % 2) echo 'odd'; else echo 'even';?>">
		<td class="first">&nbsp;</td>
		<td><?= @helper('grid.checkbox', array('row' => $venue))?></td>
		<td><a href="<?=@route('view=venue&id='.$venue->id)?>"><?=$venue->title?></a></td>
		<td><?=$venue->address?></td>
		<td><?=$venue->geolocated_city?></td>
		<td><?=$venue->geolocated_country?></td>
		<td class="biggest"><a href="<?=@route('view=events&ohanah_venue_id='.$venue->id.'&format=html')?>"><?= @service('com://admin/ohanah.model.events')->set('ohanah_venue_id', $venue->id)->set('filterEvents', 'notpast')->getTotal() ?><img src="media://com_ohanah/v2/ohanah_images/icon_openview.png" /></a></td>
		<td><?= @helper('grid.enable', array('row' => $venue)) ?></td>
	</tr>
<? endforeach ?>