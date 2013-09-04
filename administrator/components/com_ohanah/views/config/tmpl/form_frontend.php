<div class="panelContent">
	<table>
		<tr>
			<span class="fieldTitle"><input type="checkbox" name="enable_frontend" value="0" <? if ($params->enable_frontend == '1') echo 'checked' ?> /><?=@text('OHANAH_ALLOW_FRONTEND_SUBMISSION_OF_EVENTS'); ?></span><br/>
		</tr>
		<tr>
			<span class="fieldTitle frontend-enabled frontend_editing"><input type="checkbox" name="frontend_editing" value="0" <? if ($params->frontend_editing == '1') echo 'checked' ?> /><?=@text('Enable frontend editing'); ?></span><br/>
		</tr>
		<tr>
			<span class="fieldTitle frontend-enabled frontend-editing-enabled"><input type="checkbox" name="moderation" value="0" <? if ($params->moderation == '1') echo 'checked' ?> /><?=@text('OHANAH_AUTO_PUBLISH_FRONTEND_EVENTS'); ?></span><br/>
		</tr>
		<tr>
			<span class="fieldTitle frontend-enabled frontend-editing-enabled"><?=@text('OHANAH_URL_TO_REDIRECT_AFTER_EVENT_ADD'); ?></span><br/><input type="text" id="redirect_after_add_event" name="redirect_after_add_event" class="text frontend-enabled frontend-editing-enabled" value="<?=$params->redirect_after_add_event?>" />
		</tr>
	</table>
</div>

<script>

	$jq(function() {
		$jq('input[name="enable_frontend"]:checkbox').click(function(){
			if ($jq(this).attr('checked') == 'checked') { 
				$jq('.frontend_editing').show();
				if ($jq('input[name="frontend_editing"]:checkbox').attr('checked') !== 'checked') { $jq('.frontend-editing-enabled').show(); }  
			} 
			else { $jq('.frontend-enabled').hide(); }
		});

		<? if ($params->enable_frontend == 0) : ?>
			$jq('.frontend-enabled').hide();
		<? endif ?>
	});					

	$jq(function() {
		$jq('input[name="frontend_editing"]:checkbox').click(function(){
			if ($jq(this).attr('checked') !== 'checked') { $jq('.frontend-editing-enabled').show(); } 
			else { $jq('.frontend-editing-enabled').hide(); }
		});

		<? if ($params->frontend_editing !== 0) : ?>
			$jq('.frontend-editing-enabled').hide();
		<? endif ?>
	});					
</script>