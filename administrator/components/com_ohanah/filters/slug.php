<?php

class ComOhanahFilterSlug extends KFilterSlug
{
	public function just_clean($string)
	{
		// Replace other special chars
		$specialCharacters = array(
		'#' => '',
		'$' => '',
		'%' => '',
		'&' => '',
		'@' => '',
		'.' => '',
		'€' => '',
		'+' => '',
		'=' => '',
		'§' => '',
		'\\' => '',
		'/' => '',
		'|' => '',
		'?' => '',
		'£' => '',
		'(' => '',
		')' => '',
		'{' => '',
		'}' => '',
		'[' => '',
		']' => '',
		'^' => '',
		',' => '',
		':' => '',
		'«' => '',
		'»' => '',
		'’' => '',
		'”' => '',
		'"' => '',
		'\'' => '',
		'“' => ''
		);

		while (list($character, $replacement) = each($specialCharacters)) {
			$string = str_replace($character, $replacement, $string);
		}
		
		$string = str_replace(' ', '-', trim($string));
  		//$string =  str_replace( array('à','á','â','ã','ä', 'ç', 'è','é','ê','ë', 'ì','í','î','ï', 'ñ', 'ò','ó','ô','õ','ö', 'ù','ú','û','ü', 'ý','ÿ', 'À','Á','Â','Ã','Ä', 'Ç', 'È','É','Ê','Ë', 'Ì','Í','Î','Ï', 'Ñ', 'Ò','Ó','Ô','Õ','Ö', 'Ù','Ú','Û','Ü', 'Ý'), array('a','a','a','a','a', 'c', 'e','e','e','e', 'i','i','i','i', 'n', 'o','o','o','o','o', 'u','u','u','u', 'y','y', 'A','A','A','A','A', 'C', 'E','E','E','E', 'I','I','I','I', 'N', 'O','O','O','O','O', 'U','U','U','U', 'Y'), $string); 

		$string = preg_replace('/^[\-]+/', '', $string);
		$string = preg_replace('/[\-]+$/', '', $string);
		$string = preg_replace('/[\-]{2,}/', ' ', $string);

		return $string;
	}
	
	/**
	 * Sanitize a value
	 * 
	 * Modified Ohanah version to take care of unicode slugs Joomla 1.6/1.7 parameter
	 * 
	 * @param	scalar	Variable to be sanitized
	 * @return	scalar
	 */
	protected function _sanitize($value)
	{
		//remove any '-' from the string they will be used as concatonater
		$value = str_replace($this->_separator, ' ', $value);
		
        if (!JFactory::getApplication()->getCfg('unicodeslugs')) {
			//convert to ascii characters
			$value = $this->getService('koowa:filter.ascii')->sanitize($value);
	    }

		//lowercase and trim
		$value = trim(strtolower($value));
		
        if (JFactory::getApplication()->getCfg('unicodeslugs')) {
			$value = $this->just_clean($value);
	    } else {
  			//remove any duplicate whitespace, and ensure all characters are alphanumeric
	    	$value = preg_replace(array('/\s+/','/[^A-Za-z0-9\-]/'), array($this->_separator,''), $value);
            $value = $this->just_clean($value);
	    }

		//limit length
		if (strlen($value) > $this->_length) {
			$value = substr($value, 0, $this->_length);
		}

		return $value;
	}
}