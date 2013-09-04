<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php 
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

jimport('joomla.filesystem.file');

class ComOhanahControllerAttachment extends ComOhanahControllerCommon 
{
	protected function _saveFile($file, $target_type, $target_id) {
		if (JFile::exists($file['tmp_name'])) {
			$fileSafeName = JFile::makeSafe($file['name']);

			$allowed_images_extensions = array('jpg', 'jpeg', 'png', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF');

			if (in_array(JFile::getExt($fileSafeName), $allowed_images_extensions))
			{
				$randomNumber = rand();
				if (JFile::upload($file['tmp_name'], JPATH_ROOT.DS.'media/com_ohanah/attachments'.DS.$randomNumber.'-'.$fileSafeName)) {
					$file_name = $randomNumber.'-'.$fileSafeName;
					$this->_createThumb($file_name);
					return $file_name;
				} else return false;
			} else return false;
		}
	}
	
	protected function _createThumb($file) {
		if (extension_loaded('gd') && function_exists('gd_info')) { //Create thumb only if GD Library is installed
			$thumbpath = JPATH_ROOT.DS.'media/com_ohanah/attachments_thumbs'.DS.$file;
			
			$image = new SimpleImage();
			$image->load(JPATH_ROOT.DS.'media/com_ohanah/attachments'.DS.$file);
			
			list($width, $height, $type, $attr) = getimagesize(JPATH_ROOT.DS.'media/com_ohanah/attachments'.DS.$file);
			
			if ($width > $height) {
				$image->resizeToWidth(367);
			} else {
				$image->resizeToHeight(314);
			}

			$image->save($thumbpath);
		}
	}

	protected function _actionAdd(KCommandContext $context) {
		$data = $context->data;
		unset($data->id);

		if ($data->random_id) {
			$data->target_type = 'temp_'.$data->target_type;
			$data->target_id = $data->random_id;
		}

		$returnValue = '';

		if ($data->imageType == 'picture') {
			$returnValue = $this->_saveFile($_FILES['pictureUpload'], $data->target_type, $data->target_id);
		} elseif ($data->imageType == 'photo') {
			$returnValue = $this->_saveFile($_FILES['photoUpload'], $data->target_type, $data->target_id);
		}

		if ($returnValue) {
			$data->name = $returnValue;

			$context->data = $data;
			parent::_actionAdd($context);
		}

		echo $returnValue;
		exit();
	}

	protected function _actionDeleteimage(KCommandContext $context)
	{
		$data = $context->data;
		unset($data->description);

		$images = $this->getService('com://admin/ohanah.model.attachments')->set('target_type', $data->target_type)->set('target_id', $data->target_id)->set('name', $data->name)->getList();

		foreach ($images as $image) {
	 		JFile::delete(JPATH_ROOT.DS.'media/com_ohanah/attachments'.DS.$image->name);
	 		JFile::delete(JPATH_ROOT.DS.'media/com_ohanah/attachments_thumbs'.DS.$image->name);
	
	 		$image->delete();
	 	}		
	}
}


/*
* File: SimpleImage.php
* Author: Simon Jarvis
* Copyright: 2006 Simon Jarvis
* Date: 08/11/06
* Link: http://www.white-hat-web-design.co.uk/articles/php-image-resizing.php
* 
* This program is free software; you can redistribute it and/or 
* modify it under the terms of the GNU General Public License 
* as published by the Free Software Foundation; either version 2 
* of the License, or (at your option) any later version.
* 
* This program is distributed in the hope that it will be useful, 
* but WITHOUT ANY WARRANTY; without even the implied warranty of 
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the 
* GNU General Public License for more details: 
* http://www.gnu.org/licenses/gpl.html
*
*/
 
class SimpleImage {
   
	var $image;
   	var $image_type;
 
   	function load($filename) {
      	$image_info = getimagesize($filename);
      	$this->image_type = $image_info[2];
      	if( $this->image_type == IMAGETYPE_JPEG ) {
         	$this->image = imagecreatefromjpeg($filename);
      	} elseif( $this->image_type == IMAGETYPE_GIF ) {
         	$this->image = imagecreatefromgif($filename);
      	} elseif( $this->image_type == IMAGETYPE_PNG ) {
         	$this->image = imagecreatefrompng($filename);
      	}
   	}
   
	function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {
      	if( $image_type == IMAGETYPE_JPEG ) {
         	imagejpeg($this->image,$filename,$compression);
      	} elseif( $image_type == IMAGETYPE_GIF ) {
         	imagegif($this->image,$filename);         
      	} elseif( $image_type == IMAGETYPE_PNG ) {
         	imagepng($this->image,$filename);
      	}   
      	if( $permissions != null) {
         	chmod($filename,$permissions);
      	}
   	}
   
	function output($image_type=IMAGETYPE_JPEG) {
      	if( $image_type == IMAGETYPE_JPEG ) {
         	imagejpeg($this->image);
      	} elseif( $image_type == IMAGETYPE_GIF ) {
         	imagegif($this->image);         
      	} elseif( $image_type == IMAGETYPE_PNG ) {
         	imagepng($this->image);
      	}   
   	}

   	function getWidth() {
      	return imagesx($this->image);
   	}

   	function getHeight() {
      	return imagesy($this->image);
   	}

   	function resizeToHeight($height) {
      	$ratio = $height / $this->getHeight();
      	$width = $this->getWidth() * $ratio;
      	$this->resize($width,$height);
   	}

   	function resizeToWidth($width) {
      	$ratio = $width / $this->getWidth();
      	$height = $this->getheight() * $ratio;
      	$this->resize($width,$height);
   	}

   	function scale($scale) {
      	$width = $this->getWidth() * $scale/100;
      	$height = $this->getheight() * $scale/100; 
      	$this->resize($width,$height);
   	}
   	
	function resize($width,$height) {
      	$new_image = imagecreatetruecolor($width, $height);
      	imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      	$this->image = $new_image;   
   	}
}