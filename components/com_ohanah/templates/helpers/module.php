<?php

class ComOhanahTemplateHelperModule extends KTemplateHelperBehavior
{
 	public function injector($config = array())
	{
		$config = new KConfig($config);
	
		$return = '';
		
		if ($config->placeholder) {
			if (count($modules = JModuleHelper::getModules($config->placeholder))) {
				foreach($modules as $module) {
					$module_params = new JParameter($module->params);

					if ($config->title) {
						$title = 'title="'.$config->title.'"';
					} else {
						$module->showtitle ? $title = 'title="'.$module->title.'"' : $title = '';					
					}

					$config->sfx ? $sfx = $config->sfx : $sfx = $module_params->get('moduleclass_sfx');

					$string = '<module prepend="0" params="moduleclass_sfx='.$sfx.'" '.$title.' position="'.$config->position.'">';
					$string .= JModuleHelper::renderModule($module);
					$string .= '</module>';

					$return = $string.$return;
				}
			}
		} else {
			if ($config->content) {
				$return .= '<module prepend="0" params="moduleclass_sfx='.$sfx.'" title="'.$config->title.'" position="'.$config->position.'">';
				$return .= $config->content;
				$return .= '</module>';
			}
		}

		return $return;
	}
}