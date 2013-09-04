jQuery.noConflict()(function() {
	var tog = false;
	
	jQuery('#toggle').click(function() {
		jQuery('.-koowa-grid-checkbox').attr("checked",!tog);
		tog = !tog;
		if (tog) {
			jQuery('table.toolbar a.toolbar[data-action]').attr('disabled', false);
			jQuery('table.toolbar a.toolbar[data-action]').removeClass('disabled');
		} else {
			jQuery('table.toolbar a.toolbar[data-action]').attr('disabled', true);
			jQuery('table.toolbar a.toolbar[data-action]').addClass('disabled');
		} 
	});
});