<? (defined('_JEXEC') && defined('KOOWA')) or die('Restricted access'); ?>

<tr>
	<th class="first">&nbsp;</th>
	<th><input type='checkbox' id='toggle' /></th>
	<th><?= @helper('grid.sort', array('column' => 'title')); ?></th>
	<th><?= @helper('grid.sort', array('column' => 'description', 'title' => 'OHANAH_DESCRIPTION')); ?></th>
	<th><?=@text('EVENTS');?></th>
	<th><?= @helper('grid.sort', array('column' => 'enabled', 'title' => 'P')); ?></th>
</tr>

<? $i = 0; ?>
<? foreach ($categories as $category) : ?>
	<tr class="<? if ($i++ % 2) echo 'odd'; else echo 'even';?>">
		<td class="first">&nbsp;</td>
		<td><?= @helper('grid.checkbox', array('row' => $category))?></td>
		<td><a href="<?=@route('view=category&id='.$category->id)?>"><?=$category->title?></a></td>
		<td style="max-width:350px; padding-right:50px"><?=$category->description?></td>
		<td class="biggest"><a href="<?=@route('view=events&ohanah_category_id='.$category->id.'&format=html')?>"><?= @service('com://admin/ohanah.model.events')->set('ohanah_category_id', $category->id)->set('filterEvents', 'notpast')->getTotal() ?><img src="media://com_ohanah/v2/ohanah_images/icon_openview.png" /></a></td>
		<td><?= @helper('grid.enable', array('row' => $category)) ?></td>
	</tr>
<? endforeach ?>