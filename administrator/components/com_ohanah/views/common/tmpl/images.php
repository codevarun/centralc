<script>
	//IMAGE ARRAYS
	var eventPicture = "<?=$item->picture?>";
	var photos = new Array();

	function removePicture(picture){
		eventPicture = "";
		jQuery('#picture').val('');

		createPicture();

		jQuery("#edit-form").ajaxForm({
			url: 'index.php?option=com_ohanah&view=attachment',
			data: { action:'deleteimage', 
				<? if ($item->id) : ?>
					target_type: '<?=$name?>', 
					target_id: <?=$item->id?>,
					name: picture
				<? else : ?>
					target_type: 'temp_<?=$name?>',
					target_id: random,
					name: picture
				<? endif ?>}
		}).submit();
	}
	
	<? if (!$item->id) : ?>
		var random = Math.floor(Math.random()*5000);
		jQuery('#random_id').val(random);
	<? endif ?>

	<? if ($item->id) : ?>
		<? $images = @service('com://admin/ohanah.model.attachments')->set('target_type', $name)->set('target_id', $item->id)->getList() ?>
		<? foreach ($images as $image) : ?>
			<? if ($name != 'event' || $image->name != $item->picture) : ?>
				photos.push('<?=$image->name?>');
			<? endif ?>
		<? endforeach ?>
	<? endif ?>

	function removePhoto(photo, i){
		photos = removeItems(photos, photo);
		createPhotos();

		jQuery("#edit-form").ajaxForm({
			url: 'index.php?option=com_ohanah&view=attachment',
			data: { action:'deleteimage', 
				<? if ($item->id) : ?>
					target_type: '<?=$name?>', 
					target_id: <?=$item->id?>,
					name: photo
				<? else : ?>
					target_type: 'temp_<?=$name?>',
					target_id: random,
					name: photo
				<? endif ?>}
		}).submit();
	}

	function createPicture() {
		if (eventPicture=="") {
			jQuery("#eventPicture").html('<table><tr><td><input id="selectPicture" type="button" class="button" value="<?=addslashes(@text('OHANAH_SELECT_NEW'))?>"><label class="cabinet"><input type="file" class="file" name="pictureUpload" id="pictureUpload" /></label></td></tr></table>');
		} else {
			jQuery('#picture').val(eventPicture);
			jQuery("#eventPicture").html('<table><tr><td><div class="photoOver section"><div class="photo"><div style="background:url(\'http://<?=$_SERVER['HTTP_HOST'].KRequest::root()?>/media/com_ohanah/attachments/'+eventPicture+'\') center center no-repeat;"><img width="249" height="242" src="http://<?=$_SERVER['HTTP_HOST'].KRequest::root()?>/media/com_ohanah/v2/ohanah_images/blank.gif" class="picBorder" /><div class="buttonOverlay"><ul class="photoButtons"><li><a href="javascript:removePicture(\''+eventPicture+'\');" class="deletePhoto">Delete</a></li><li><a href="http://<?=$_SERVER['HTTP_HOST'].KRequest::root()?>/media/com_ohanah/attachments/'+eventPicture+'" target="_blank" class="zoomPhoto">Zoom</a></li></ul></div></div></div></div></td><td><input id="selectPicture" type="button" class="button" value="<?=@text('OHANAH_SELECT_NEW')?>"><label class="cabinet"><input type="file" class="file" name="pictureUpload" id="pictureUpload" /></label></td></tr></table>');
		}
		createPhotoToolbars();
	}


	function createPhotos() {
		jQuery( "#eventPhotos" ).html('');	
		var eventPhotos = '<table><tr>';
		var i = 0;
		jQuery.each(photos, function(key, value) { 
			eventPhotos +='<td>';
			eventPhotos += '<div class="photoOver section" id="photo_container_'+i+'"><div class="photo"><div style="background:url(\'http://<?=$_SERVER['HTTP_HOST'].KRequest::root()?>/media/com_ohanah/attachments/'+value+'\') center center no-repeat;"><img width="110" height="113" src="http://<?=$_SERVER['HTTP_HOST'].KRequest::root()?>/media/com_ohanah/v2/ohanah_images/blank.gif" class="picBorder2" /><div class="buttonOverlay"><ul class="photoButtons"><li><a href="javascript:removePhoto(\''+value+'\', '+i+');" class="deletePhoto">Delete</a></li><li><a href="http://<?=$_SERVER['HTTP_HOST'].KRequest::root()?>/media/com_ohanah/attachments/'+value+'" target="_blank" class="zoomPhoto">Zoom</a></li></ul></div></div></div></div>';
			if (((key+1)%3)==0) {
				eventPhotos +='</td></tr><tr>';
			} else {
				eventPhotos +='</td>';
			} 
			i++;
		});
		if(photos==""){
			eventPhotos += '';
		}
		eventPhotos +='<td><input type="button" class="button" value="<?=addslashes(@text('OHANAH_ADD_PHOTOS'));?>"><label class="cabinet"><input type="file" class="file" name="photoUpload" id="photoUpload" /></label></td>'
		if(((photos.length)%3)==1) {
			eventPhotos +='<td><img width="104" height="106" src="http://<?=$_SERVER['HTTP_HOST'].KRequest::root()?>/media/com_ohanah/v2/ohanah_images/blank.gif" /></td>';
		}
		eventPhotos +='</tr></table>';
		jQuery( "#eventPhotos" ).append(eventPhotos);
		createPhotoToolbars();
	}

	function createPhotoToolbars(){
		//PHOTO TOOLBARS
		jQuery('.photoOver').mouseenter(function(index) {
			jQuery(this).find('.photoButtons').css('opacity', '1');
			jQuery(this).find('.photoButtons').css('top', jQuery(this).find('.photo').width()/-2+12+'px');
			jQuery(this).find('.photoButtons').css('left', jQuery(this).find('.photo').height()/2-28+'px');
		});
		jQuery('.photoOver').mouseleave(function(index) {
			jQuery(this).find('.photoButtons').css('opacity', '0');
		});
	}

	function removeItems(array, item) {
		var i = 0;
		while (i < array.length) {
			if (array[i] == item) {
				array.splice(i, 1);
			} else {
				i++;
			}
		}
		return array;
	}

	jQuery(document).ready(function() {

		function processPicture(responseText, statusText, xhr, form)  { 
			//alert('status: ' + statusText + '\n\nresponseText: \n' + responseText); 
			eventPicture = responseText;
			createPicture();
		}
		
		function processPhoto(responseText, statusText, xhr, form)  { 
			//alert('status: ' + statusText + '\n\nresponseText: \n' + responseText); 
			photos.push(responseText);
			createPhotos();
		}

		//PROCESS IMAGE UPLOADS
		jQuery('#pictureUpload').live('change', function(){
			jQuery("#edit-form").ajaxForm({
				url: 'index.php?option=com_ohanah&view=attachment',
				data: { imageType: 'picture', target_type: '<?=$name?>' <? if ($item->id) : ?>, target_id: <?=$item->id?><? endif ?>},
				success: processPicture
			}).submit();
		});

		jQuery('#photoUpload').live('change', function(){
			jQuery("#edit-form").ajaxForm({
				url: 'index.php?option=com_ohanah&view=attachment',
				data: { imageType: 'photo', target_type: '<?=$name?>' <? if ($item->id) : ?>, target_id: <?=$item->id?><? endif ?>},
				success: processPhoto
			}).submit();
		});

		//CREATE IMAGES
		createPicture();
		createPhotos();

		//STYLE FAKE UPLOADERS
		SI.Files.stylizeAll();
	
		
		//PHOTO TOOLBARS
		jQuery('.photoOver').mouseenter(function(index) {
			jQuery(this).find('.photoButtons').css('opacity', '1');
			jQuery(this).find('.photoButtons').css('top', jQuery(this).find('.photo').width()/-2+12+'px');
			jQuery(this).find('.photoButtons').css('left', jQuery(this).find('.photo').height()/2-28+'px');
		});
		jQuery('.photoOver').mouseleave(function(index) {
			jQuery(this).find('.photoButtons').css('opacity', '0');
		});
	});
</script>
