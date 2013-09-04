<? (defined('_JEXEC') && defined('KOOWA')) or die('Restricted access'); ?>

<tr>
	<th class="first">&nbsp;</th>
	<th><input type='checkbox' id='toggle' /></th>
	<th><?= @helper('grid.sort', array('column' => 'name', 'title' => 'OHANAH_NAME')); ?></th>
	<th></th>
	<th><?= @helper('grid.sort', array('column' => 'email', 'title' => 'OHANAH_EMAIL')); ?></th>
	<th width="40"><?=@text('OHANAH_NUMBER_OF_TICKETS') ?></th>
	<th><?= @helper('grid.sort', array('column' => 'checked_in', 'title' => 'OHANAH_CHECKED_IN')); ?></th>
	<th style="padding-right:10px"><?= @helper('grid.sort', array('column' => 'paid', 'title' => 'OHANAH_PAID')); ?></th>
</tr>

<? $i = 0; ?>
<? foreach ($registrations as $registration) : ?>
	<tr class="<? if ($i++ % 2) echo 'odd'; else echo 'even';?>">
		<td class="first">&nbsp;</td>
		<td><?=@helper('grid.checkbox', array('row' => $registration))?></td>
		<td width="1%"><a href="<?=@route('view=registration&id='.$registration->id)?>"><?=$registration->getGravatar()?></a></td>
		<td>&nbsp;<a href="<?=@route('view=registration&id='.$registration->id)?>"><?=$registration->name?></a></td>
		<td width="20%"><a href="<?=@route('view=registrations&layout=sendmail&ohanah_event_id='.KRequest::get('get.ohanah_event_id', 'int').'=&id[]='.$registration->id)?>"><?=$registration->email ?></a></td>
		<td width="50%"><?=$registration->number_of_tickets ?></td>
		<td align="center" width="80px"><?=@helper('grid.checked_in', array('row' => $registration)) ?></td>		
		<td align="center" width="2%"><?=@helper('grid.paid', array('row' => $registration)) ?></td>		
	</tr>
<? endforeach ?>