<?php
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

defined('_JEXEC') or die('Restricted access');

class ComOhanahViewRegistrationsCsv extends KViewCsv
{
	public function display()
	{
		$event = $this->getService('com://admin/ohanah.model.events')->set('id', KRequest::get('get.ohanah_event_id', 'int'))->getItem();
		$registrations = $this->getService('com://admin/ohanah.model.registrations')->set('ohanah_event_id', $event->id)->getList();
		
		$array = array('name', 
			'surname', 
			'email', 
			'number_of_tickets', 
			'notes', 
			'registration_date', 
			'paid', 
			'checked_in',
			'name of person 2',
			'name of person 3',
			'name of person 4',
			'name of person 5',
			'name of person 6',
			);

		$active_custom_fields = new JParameter($event->customfields); 

		for ($indexField = 1; $indexField <= 10; $indexField++) {
			if ($active_custom_fields->get('cf'.$indexField)) {
				for ($j = 1; $j <= 6; $j++) 
					$array[] = $active_custom_fields->get('custom_field_label_'.$indexField).' of person '.$j;
			}
		}

		$this->output .= $this->_arrayToString($array).$this->eol;
		
		foreach($registrations as $registration) {

			$array = array(
					'name' => $registration->name,
					'surname' => $registration->surname,
					'email' => $registration->email,
					'number_of_tickets' => $registration->number_of_tickets,
					'notes' => $registration->notes,
					'registration_date' => $registration->created_on,
					'paid' => $registration->paid,
					'checked_in' => $registration->checked_in,
					'name of person 2' => '',
					'name of person 3' => '',
					'name of person 4' => '',
					'name of person 5' => '',
					'name of person 6' => '',
					);

			$params = new JParameter($registration->params);

			for ($i = 2; $i <= 6; $i++) {		
				$array['name of person '.$i] = $params->get('field_name_person_'.$i);
			}

			for ($indexField = 1; $indexField <= 10; $indexField++) {
				for ($i = 1; $i <= 6; $i++) {
					if ($active_custom_fields->get('cf'.$indexField)) 
						$array[$active_custom_fields->get('custom_field_label_'.$indexField).' of person '.$i] = $params->get('custom_field_value_'.$indexField.'_person_'.$i);
				}	
			}

			$this->output .= $this->_arrayToString($array).$this->eol;

		}
		
		return KViewFile::display();
	}
}