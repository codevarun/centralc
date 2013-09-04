<?php

class ComOhanahTemplateHelperButton extends KTemplateHelperAbstract
{
 	public function button($config = array())
	{
		$config = new KConfig($config);
		$style = JComponentHelper::getParams('com_ohanah')->get('buttons_style');
		$return = '';

		if ($config->type == 'input') {

			$return = '<input type="submit" value="'.$config->text.'">';

			if ($style == 'ohanah') {
				$return = '<div class="button"><input type="submit" name="Submit" value="'.$config->text.'" /></div>';
			} elseif ($style == 'rockettheme') {
				$return = '<div class="readon"><input type="submit" name="Submit" class="button" value="'.$config->text.'"></div>';	
			} elseif ($style == 'yootheme') {
				$return = '<div class="button"><button class="button" value="'.$config->text.'" name="Submit" type="submit">'.$config->text.'</button></div>';	
			} elseif ($style == 'gavick') {
				$return = '<div class="button"><input type="submit" value="'.$config->text.'" class="button" name="Submit"></div>';	
			} elseif ($style == 'joomlart') {
				$return = '<button type="submit" class="button" name="Submit">'.$config->text.'</button>';
			} elseif ($style == 'joomlaxtc') {
				$return = '<button class="button btnmore" type="submit">'.$config->text.'</button>';
			} elseif ($style == 'joomlabamboo') {
				$return = '<input type="submit" name="submit" class="button" value="'.$config->text.'">';
			}
			
		} elseif ($config->type == 'link') {

			$return = '<a href="'.$config->link.'">'.$config->text.'</a>';
			
			if ($style == 'ohanah') {
				$return = '<a href="'.$config->link.'" class="button">'.$config->text.'</a>';
			} elseif ($style == 'rockettheme') {
				$return = '<a href="'.$config->link.'" class="readon register-link-button"><span>'.$config->text.'</span></a>';	
			} elseif ($style == 'yootheme') {
				$return = '<a class="button-more" href="'.$config->link.'">'.$config->text.'</a>';
			} elseif ($style == 'gavick') {
				$return = '<a class="readon readon_class" href="'.$config->link.'">'.$config->text.'</a>';
			} elseif ($style == 'joomlart') {
				$return = '<p class="readmore"><a href="'.$config->link.'">'.$config->text.'</a></p>';
			} elseif ($style == 'joomlaxtc') {
				$return = '<a class="btn" href="'.$config->link.'">'.$config->text.'</a>';
			}
			
		}

		return $return;
	}
}