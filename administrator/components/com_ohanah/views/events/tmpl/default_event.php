<tr class="<? if ($i % 2) echo 'odd'; else echo 'even';?>">
	<td class="first">&nbsp;</td>
	<td>
		<? if ($event->isRecurring()) : ?>
			<? if ($event->recurringParent) : ?>
				<a href="<?=@route('view=events&recurringParent='.$event->recurringParent)?>"><img class="recurring_status_icon" src="media://com_ohanah/v2/ohanah_images/icon-handle.png" title="this event is part of a series"/></a>&nbsp;
			<? else : ?>
				<a href="<?=@route('view=events&recurringParent='.$event->id)?>"><img class="recurring_status_icon" src="media://com_ohanah/v2/ohanah_images/icon-handle-master.png" title="this event is the master of a series"/></a>&nbsp;
			<? endif ?>
		<? endif ?>
	</td>
	<td><?= @helper('grid.checkbox', array('row' => $event))?></td>
	<td><a href="<?=@route('view=event&id='.$event->id)?>"><?=$event->title?></a></td>
	<td>
		<?= @helper('date.format', array('date' => $event->date, 'format' => '%d', 'gmt_offset' => '0')) ?>
		<?= @text(@helper('date.format', array('date' => $event->date, 'format' => '%B', 'gmt_offset' => '0'))) ?>
		<?= @helper('date.format', array('date' => $event->date, 'format' => '%Y', 'gmt_offset' => '0')) ?>
	</td>
	<td><?=$this->getService('com://admin/ohanah.model.categories')->id($event->ohanah_category_id)->getItem()->title?></td>
	<td><?=$this->getService('com://admin/ohanah.model.venues')->id($event->ohanah_venue_id)->getItem()->title?></td>
	<td class="biggest"><a href="<?=@route('ohanah_event_id='.$event->id.'&view=registrations&format=html')?>"><?= $event->countAttendees() ?><img src="media://com_ohanah/v2/ohanah_images/icon_openview.png" title="<?=@text('OHANAH_MANAGE_REGISTRATIONS')?>" /></a>
	</td>
	<? if (KRequest::get('get.frontend_submitted', 'string')) : ?>
		<td>
			<a href="
				<? if (!$event->created_by) : ?><? if ($event->created_by_email) : ?>mailto:<?=$event->created_by_email?><? else : ?>#<? endif ?>
				<? else : ?>
					<? $joomlaVersion = JVersion::isCompatible('1.6.0') ? '>1.5' : '1.5'; ?>
					<? if ($joomlaVersion == '>1.5') : ?>
						index.php?option=com_users&view=user&layout=edit&id=<?=$event->created_by?>
					<? else : ?>
						index.php?option=com_users&view=user&task=edit&cid[]=<?=$event->created_by?>
					<? endif ?>
				<? endif ?>
			">
				<?=$event->created_by_name?>
			</a>
		</td>
	<? endif ?>
	<td><?= @helper('grid.enable', array('row' => $event)) ?></td>
	<td><?= @helper('grid.feature', array('row' => $event)) ?></td>
</tr>