<div class="panelContent">
	<table>
		<tr>
			<td class="part-left">			
				<div>

					<span class="fieldTitle"><?=@text('OHANAH_WHAT_SHOULD_OHANAH_SHOW');?></span><br/>
					<table id="what-should-ohanah-show" style="width:400px">
						<tr>
							<th style="text-align:left"><?=@text('OHANAH_WHAT');?></th>
							<th style="text-align:left"><?=@text('OHANAH_IN_EVENTS_LIST');?></th>
							<th style="text-align:left"><?=@text('OHANAH_IN_SINGLE_EVENT');?></th>
							<th style="text-align:left"><?=@text('OHANAH_EVENT_REGISTRATION_VIEW');?></th>
							<th style="text-align:left"><?=@text('OHANAH_IN_MODULE');?></th>
						</tr>
						<tr>
							<td><?=@text('OHANAH_LINK_TO_CATEGORY');?></td>
							<td><input type="checkbox" name="showLinkToCategoryInList" value="0" <? if ($params->showLinkToCategoryInList == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showLinkToCategoryInSingle" value="0" <? if ($params->showLinkToCategoryInSingle == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showLinkToCategoryInRegistration" value="0" <? if ($params->showLinkToCategoryInRegistration == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showLinkToCategoryInModule" value="0" <? if ($params->showLinkToCategoryInModule == '1') echo 'checked' ?> /></td>
						</tr>
						<tr>
							<td><?=@text('OHANAH_LINK_TO_VENUE');?></td>
							<td><input type="checkbox" name="showLinkToVenueInList" value="0" <? if ($params->showLinkToVenueInList == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showLinkToVenueInSingle" value="0" <? if ($params->showLinkToVenueInSingle == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showLinkToVenueInRegistration" value="0" <? if ($params->showLinkToVenueInRegistration == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showLinkToVenueInModule" value="0" <? if ($params->showLinkToVenueInModule == '1') echo 'checked' ?> /></td>
						</tr>
						<tr>
							<td><?=@text('OHANAH_RECURRING_SET_LINK');?></td>
							<td><input type="checkbox" name="showLinkToRecurringSetInList" value="0" <? if ($params->showLinkToRecurringSetInList == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showLinkToRecurringSetInSingle" value="0" <? if ($params->showLinkToRecurringSetInSingle == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showLinkToRecurringSetInRegistration" value="0" <? if ($params->showLinkToRecurringSetInRegistration == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showLinkToRecurringSetInModule" value="0" <? if ($params->showLinkToRecurringSetInModule == '1') echo 'checked' ?> /></td>
						</tr>
						<tr>
							<td><?=@text('OHANAH_SAVE_TO_CAL_LINK');?></td>
							<td><input type="checkbox" name="showLinkToSaveToCalInList" value="0" <? if ($params->showLinkToSaveToCalInList == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showLinkToSaveToCalInSingle" value="0" <? if ($params->showLinkToSaveToCalInSingle == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showLinkToSaveToCalInRegistration" value="0" <? if ($params->showLinkToSaveToCalInRegistration == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showLinkToSaveToCalInModule" value="0" <? if ($params->showLinkToSaveToCalInModule == '1') echo 'checked' ?> /></td>
						</tr>
						<tr>
							<td><?=@text('OHANAH_COST_INFO');?></td>
							<td><input type="checkbox" name="showCostInfoInList" value="0" <? if ($params->showCostInfoInList == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showCostInfoInSingle" value="0" <? if ($params->showCostInfoInSingle == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showCostInfoInRegistration" value="0" <? if ($params->showCostInfoInRegistration == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showCostInfoInModule" value="0" <? if ($params->showCostInfoInModule == '1') echo 'checked' ?> /></td>
						</tr>
						<tr>
							<td><?=@text('OHANAH_PLACES_LEFT');?></td>
							<td><input type="checkbox" name="showPlacesLeftInList" value="0" <? if ($params->showPlacesLeftInList == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showPlacesLeftInSingle" value="0" <? if ($params->showPlacesLeftInSingle == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showPlacesLeftInRegistration" value="0" <? if ($params->showPlacesLeftInRegistration == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showPlacesLeftInModule" value="0" <? if ($params->showPlacesLeftInModule == '1') echo 'checked' ?> /></td>
						</tr>
						<tr>
							<td><?=@text('OHANAH_EVENT_PICTURE');?></td>
							<td><input type="checkbox" name="showEventPictureInList" value="0" <? if ($params->showEventPictureInList == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showEventPictureInSingle" value="0" <? if ($params->showEventPictureInSingle == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showEventPictureInRegistration" value="0" <? if ($params->showEventPictureInRegistration == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showEventPictureInModule" value="0" <? if ($params->showEventPictureInModule == '1') echo 'checked' ?> /></td>
						</tr>
						<tr>
							<td><?=@text('OHANAH_EVENT_FULL_DESCRIPTION');?></td>
							<td><input type="checkbox" name="showEventFullDescriptionInList" value="0" <? if ($params->showEventFullDescriptionInList == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showEventFullDescriptionInSingle" value="0" <? if ($params->showEventFullDescriptionInSingle == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showEventFullDescriptionInRegistration" value="0" <? if ($params->showEventFullDescriptionInRegistration == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showEventFullDescriptionInModule" value="0" <? if ($params->showEventFullDescriptionInModule == '1') echo 'checked' ?> /></td>
						</tr>
						<tr>
							<td><?=@text('OHANAH_EVENT_DESCRIPTION_SNIPPET');?></td>
							<td><input type="checkbox" name="showEventDescriptionSnippetInList" value="0" <? if ($params->showEventDescriptionSnippetInList == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showEventDescriptionSnippetInSingle" value="0" <? if ($params->showEventDescriptionSnippetInSingle == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showEventDescriptionSnippetInRegistration" value="0" <? if ($params->showEventDescriptionSnippetInRegistration == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showEventDescriptionSnippetInModule" value="0" <? if ($params->showEventDescriptionSnippetInModule == '1') echo 'checked' ?> /></td>
						</tr>
						<tr>
							<td><?=@text('OHANAH_EVENT_DATE');?></td>
							<td><input type="checkbox" name="showEventDateInList" value="0" <? if ($params->showEventDateInList == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showEventDateInSingle" value="0" <? if ($params->showEventDateInSingle == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showEventDateInRegistration" value="0" <? if ($params->showEventDateInRegistration == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showEventDateInModule" value="0" <? if ($params->showEventDateInModule == '1') echo 'checked' ?> /></td>
						</tr>
						<tr>
							<td><?=@text('OHANAH_BIG_DATE_BADGE');?></td>
							<td><input type="checkbox" name="showBigDateBadgeInList" value="0" <? if ($params->showBigDateBadgeInList == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showBigDateBadgeInSingle" value="0" <? if ($params->showBigDateBadgeInSingle == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showBigDateBadgeInRegistration" value="0" <? if ($params->showBigDateBadgeInRegistration == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showBigDateBadgeInModule" value="0" <? if ($params->showBigDateBadgeInModule == '1') echo 'checked' ?> /></td>
						</tr>
						<tr>
							<td><?=@text('OHANAH_EVENT_ADDRESS');?></td>
							<td><input type="checkbox" name="showEventAddressInList" value="0" <? if ($params->showEventAddressInList == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showEventAddressInSingle" value="0" <? if ($params->showEventAddressInSingle == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showEventAddressInRegistration" value="0" <? if ($params->showEventAddressInRegistration == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showEventAddressInModule" value="0" <? if ($params->showEventAddressInModule == '1') echo 'checked' ?> /></td>
						</tr>
						<tr>
							<td>Read more link</td>
							<td><input type="checkbox" name="showReadMoreInList" value="0" <? if ($params->showReadMoreInList == '1') echo 'checked' ?> /></td>
							<td>-</td>
							<td><input type="checkbox" name="showReadMoreInRegistration" value="0" <? if ($params->showReadMoreInRegistration == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showReadMoreInModule" value="0" <? if ($params->showReadMoreInModule == '1') echo 'checked' ?> /></td>
						</tr>
						<tr>
							<td><?=@text('OHANAH_TIME');?></td>
							<td><input type="checkbox" name="showTimeInList" value="0" <? if ($params->showTimeInList == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showTimeInSingle" value="0" <? if ($params->showTimeInSingle == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showTimeInRegistration" value="0" <? if ($params->showTimeInRegistration == '1') echo 'checked' ?> /></td>
							<td><input type="checkbox" name="showTimeInModule" value="0" <? if ($params->showTimeInModule == '1') echo 'checked' ?> /></td>
						</tr>
					</table>
				</div>
			</td>
		</tr>
	</table>
</div>