<div class="bordered">
	<div id="map_canvas_form"></div>
</div>

<input type="hidden" id="latitude" name="latitude" value="<?=htmlspecialchars(@$item->latitude)?>" />
<input type="hidden" id="longitude" name="longitude" value="<?=htmlspecialchars(@$item->longitude)?>" />
<input type="hidden" id="latlng" name="latlng" value="<?=htmlspecialchars(@$item->latlng)?>" />
<input type="hidden" id="timezone" name="timezone" value="<?=htmlspecialchars(@$item->timezone)?>" />
<?php
$config =& JFactory::getConfig();
$language = $config->getValue('config.language');

$languagesSupportedByGoogleMaps = array('ar', 'bg', 'bn', 'ca', 'cs', 'da', 'de', 'el', 'en', 'en-AU', 'en-GB', 'es', 'eu', 'fa', 'fi', 'fi', 'fr', 'gl', 'gu', 'hi', 'hr', 'hu', 'id', 'it', 'iw', 'ja', 'kn', 'ko', 'lt', 'lv', 'ml', 'mr', 'nl', 'nn', 'no', 'or', 'pl', 'pt', 'pt-BR', 'pt-PT', 'rm', 'ro', 'ru', 'sk', 'sl', 'sr', 'sv', 'tl', 'ta', 'te', 'th', 'tr', 'uk', 'vi', 'zh-CN', 'zh-TW');

if (!in_array($language, $languagesSupportedByGoogleMaps)) {
	$language = substr($language, 0, 2);
}

if (!in_array($language, $languagesSupportedByGoogleMaps)) {
	$language = 'en';
}
?>
<script src="//maps.google.com/maps/api/js?sensor=false&language=<?=$language?>" />
<script>
	$jq(function() {
		var map;
		var geocoder;
		var marker;
		
		function initialize(){
		//MAP
			<? if ($item->latitude && $item->longitude) : ?>
		  		var latlng = new google.maps.LatLng(<?=$item->latitude?>,<?=$item->longitude?>);
		  	<? else: ?>
		  	var latlng = null;
		  	<? endif; ?>

			var options = {
		    	zoom: 15,
		    	center: latlng,
		    	mapTypeId: google.maps.MapTypeId.ROADMAP,
		    	scrollwheel: false,
		    	streetViewControl: false
		  	};

		  	map = new google.maps.Map(document.getElementById("map_canvas_form"), options);
		  	geocoder = new google.maps.Geocoder();

		  	marker = new google.maps.Marker({
		    	map: map,
		    	draggable: true,
		    	position: latlng,
		    	icon: '//<?=$_SERVER['HTTP_HOST'].str_replace('/administrator', '', KRequest::base())?>/media/com_ohanah/images/ohapp_mapmarker.png'
		  	});
		}

		$jq(function() { 
			initialize();
		  	$jq(function() {			
		   		$jq("#address").autocomplete({
			      	//This bit uses the geocoder to fetch address values
			      	source: function(request, response) {

			        	geocoder.geocode( {'address': request.term }, function(results, status) {
			          		response($jq.map(results, function(item) {
			            		return {
			              			label: item.formatted_address,
			              			value: item.formatted_address,
									latitude: item.geometry.location.lat(),
						            longitude: item.geometry.location.lng()
			            		}
				          	}));
			        	})
			      	},

			      	//This bit is executed upon selection of an address
			      	select: function(event, ui) {
			        	$jq("#latitude").val(ui.item.latitude);
			        	$jq("#longitude").val(ui.item.longitude);
		            	$jq('#latlng').val(ui.item.latitude+','+ui.item.longitude);
						$jq.getJSON("http://ws.geonames.org/timezoneJSON?lat=" + ui.item.latitude + "&lng=" + ui.item.longitude, 
							function(json) {
								$jq('#timezone').val(json.gmtOffset);
							}
						);

			        	var location = new google.maps.LatLng(ui.item.latitude, ui.item.longitude);
			        	marker.setPosition(location);
			        	map.setCenter(location);
			      	}
				});
			});	

		  	//Add listener to marker for reverse geocoding
		  	google.maps.event.addListener(marker, 'drag', function() {
			   	geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
			     	if (status == google.maps.GeocoderStatus.OK) {
			       		if (results[0]) {
			         		$jq('#address').val(results[0].formatted_address);
			         		$jq('#latitude').val(marker.getPosition().lat());
			         		$jq('#longitude').val(marker.getPosition().lng());
			         		$jq('#latlng').val(marker.getPosition().toUrlValue());
							$jq.getJSON("http://ws.geonames.org/timezoneJSON?lat=" + marker.getPosition().lat() + "&lng=" + marker.getPosition().lng(), 
								function(json) {
									$jq('#timezone').val(json.gmtOffset);
								}
							);
			       		}
			     	}
			   	});
		  	});

		  	<? if ($name == 'event') : ?>

				<? $venues = @service('com://admin/ohanah.model.venues')->getList();  ?>
				<? $first = true; ?>
				var myTags = [<? foreach ($venues as $venue) : ?><? if (!$first) echo ','; $first = false; ?>"<?=addslashes($venue->title)?>"<? endforeach; ?>];

				<? if ($event->latitude && $event->longitude) : ?>
			  		var latlng = new google.maps.LatLng(<?=$event->latitude?>,<?=$event->longitude?>);
			  	<? else: ?>
			  	var latlng = null;
			  	<? endif; ?>


		   		$jq("#venue").autocomplete({
			      	//This bit uses the geocoder to fetch address values
			      	source: myTags,

			      	//This bit is executed upon selection of an address
			      	select: function(event, ui) {
			        	$jq("#latitude").val(ui.item.latitude);
				  		$jq.get('http://<?=$_SERVER['HTTP_HOST'].KRequest::root()?>/index.php?option=com_ohanah&view=venue&title='+(ui.item.value).replace('&', '%26')+'&format=json',
			  				'',
			  				function(response, status) {
								$jq('#address').val(response.item.address);
								$jq('#latitude').val(response.item.latitude);
								$jq('#longitude').val(response.item.longitude);
								$jq('#latlng').val(response.item.latitude+','+response.item.longitude);

								$jq.getJSON("http://ws.geonames.org/timezoneJSON?lat=" + response.item.latitude + "&lng=" + response.item.longitude, 
									function(json) {
										$jq('#timezone').val(json.gmtOffset);
									}
								);

					        	var location = new google.maps.LatLng(response.item.latitude, response.item.longitude);										  	
					        	marker.setPosition(location);
					        	map.setCenter(location);
							}
						);
			      	}
				});
			<? endif ?>
		});


	});
</script>