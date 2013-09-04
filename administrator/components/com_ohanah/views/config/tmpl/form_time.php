<div class="panelContent">
	<table>
		<tr>
			<span class="fieldTitle"><input type="checkbox" name="dst" value="0" <? if ($params->dst == '1') echo 'checked' ?> /><?php echo JText::_('OHANAH_SERVER_IS_IN_DST'); ?></span><br/>
		</tr>
	</table>
	<div>
		<span class="fieldTitle"><?=@text('OHANAH_TIME_FORMAT'); ?></span>
		<br/>
		<? if ($params->timeFormat) $default = $params->timeFormat; else $default = '0'; ?>
		<?= @helper('select.booleanlist', array('name' => 'timeFormat', 'selected' => $default, 'true' => 'OHANAH_12_HOURS', 'false' => 'OHANAH_24_HOURS')); ?><br />
	</div>
</div>