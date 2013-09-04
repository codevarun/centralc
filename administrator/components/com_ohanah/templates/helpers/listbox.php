<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php 
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

jimport('joomla.filesystem.file');

class ComOhanahTemplateHelperListbox extends ComDefaultTemplateHelperListbox
{
    public function categories($config = array())
    {
        $config = new KConfig($config);
        $config->append(array(
            'name'      => 'ohanah_category_id',
        ))->append(array(
            'selected'  => $config->{$config->name}
        ));
        $categories = KService::get('com://site/ohanah.model.categories')->set('published', 'true')->set('sort', 'title')->getList();

        $options = array();
        if ($config->prompt) $options[] = $this->option(array('text' => JText::_($config->prompt)));   
        else $options[] = $this->option(array('text' => JText::_('OHANAH_CATEGORY')));       

        foreach ($categories as $category) {
            if ($category) {
                if (!$config->published || $category->enabled) {
                    $options[] = $this->option(array('text' => $category->title, 'value' => $category->id));
                }    
            }
        }

        $config->options = $options;

        return $this->optionlist($config);
    }    

    public function venues($config = array())
    {
        $config = new KConfig($config);
        $config->append(array(
            'name'      => 'ohanah_venue_id',
        ));
        $venues = KService::get('com://site/ohanah.model.venues')->set('published', 'true')->set('sort', 'title')->getList();

        $options = array();
        if ($config->prompt) $options[] = $this->option(array('text' => JText::_($config->prompt)));   
        else $options[] = $this->option(array('text' => JText::_('OHANAH_VENUE')));       

        foreach ($venues as $venue) {
            if ($venue) {
                if (!$config->published || $venue->enabled) {
                    $options[] = $this->option(array('text' => $venue->title, 'value' => $venue->id));
                }    
            }
        }

        $config->options = $options;

        return $this->optionlist($config);
    }

    public function countries( $config = array())
    {
        $config = new KConfig($config);
        $config->append(array(
            'name'      => 'geolocated_country',
            'attribs'   => array(),
            'deselect'  => true,
            'prompt'    => 'OHANAH_SELECT',
        ))->append(array(
            'selected'  => $config->{$config->name}
        ));

        $events = KService::get('com://site/ohanah.model.events')
            ->set('sort', 'geolocated_country')
            ->getList();

        $array = array();

        foreach ($events as $event) {
            $array[] = $event->geolocated_country;
        }

        $array = array_unique($array);

        $options = array();
        $options[] = $this->option(array('text' => $config->prompt));   

        foreach ($array as $country) {
            if ($country) $options[] = $this->option(array('text' => $country, 'value' => $country));   
        }

        $config->options = $options;

        return $this->optionlist($config);
    }

    public function states( $config = array())
    {
        $config = new KConfig($config);
        $config->append(array(
            'name'      => 'geolocated_state',
            'attribs'   => array(),
            'deselect'  => true,
            'prompt'    => 'OHANAH_SELECT',
        ))->append(array(
            'selected'  => $config->{$config->name}
        ));

        $events = KService::get('com://site/ohanah.model.events')
            ->set('geolocated_country', KRequest::get('get.geolocated_country', 'string'))
            ->set('sort', 'geolocated_state')
            ->getList();

        $array = array();

        foreach ($events as $event) {
            $array[] = $event->geolocated_state;
        }

        $array = array_unique($array);

        $options = array();
        $options[] = $this->option(array('text' => $config->prompt));   

        foreach ($array as $city) {
            if ($city) $options[] = $this->option(array('text' => $city, 'value' => $city));   
        }

        $config->options = $options;

        return $this->optionlist($config);
    }

    public function cities( $config = array())
    {
        $config = new KConfig($config);
        $config->append(array(
            'name'      => 'geolocated_city',
            'attribs'   => array(),
            'deselect'  => true,
            'prompt'    => 'OHANAH_SELECT',
        ))->append(array(
            'selected'  => $config->{$config->name}
        ));

        $events = KService::get('com://site/ohanah.model.events')
                        ->set('geolocated_state', KRequest::get('get.geolocated_state', 'string'))
                        ->set('geolocated_country', KRequest::get('get.geolocated_country', 'string'))
                        ->set('sort', 'geolocated_city')
                        ->getList();

        $array = array();

        foreach ($events as $event) {
            $array[] = $event->geolocated_city;
        }

        $array = array_unique($array);

        $options = array();
        $options[] = $this->option(array('text' => $config->prompt));   

        foreach ($array as $city) {
            if ($city) $options[] = $this->option(array('text' => $city, 'value' => $city));   
        }

        $config->options = $options;

        return $this->optionlist($config);
    }

    public function recurring( $config = array())
    {
        $config = new KConfig($config);
        $config->append(array(
            'name'      => 'recurringParent',
            'attribs'   => array(),
            'deselect'  => true,
            'prompt'    => 'OHANAH_SELECT',
        ))->append(array(
            'selected'  => $config->{$config->name}
        ));

        $events = KService::get('com://site/ohanah.model.events')->getList();

        $array = array();

        foreach ($events as $event) {
            $array[] = $event->recurringParent;
        }

        $array = array_unique($array);

        $options = array();
        $options[] = $this->option(array('text' => $config->prompt, 'value' => 0));   

        foreach ($array as $recurringParent) {
            if ($recurringParent) if ($title = KService::get('com://site/ohanah.model.events')->id($recurringParent)->getItem()->title) $options[] = $this->option(array('text' => $title, 'value' => $recurringParent));   
        }

        $config->options = $options;

        return $this->optionlist($config);
    }

    public function yes_or_no( $config = array())
    {
        $config = new KConfig($config);
        $config->append(array(
            'name'      => 'enabled',
            'attribs'   => array(),
            'deselect'  => true,
        ))->append(array(
            'selected'  => $config->{$config->name}
        ));
        
        $options = array();
        $options[] = $this->option(array('text' => JText::_( 'OHANAH_YES' ) , 'value' => 1 ));
        $options[] = $this->option(array('text' => JText::_( 'OHANAH_NO' ), 'value' => 0 ));
    
        //Add the options to the config object
        $config->options = $options;
        
        return $this->optionlist($config);
    }

    public function direction( $config = array())
    {
        $config = new KConfig($config);
        $config->append(array(
            'name'      => 'direction',
            'attribs'   => array(),
            'deselect'  => true,
        ))->append(array(
            'selected'  => $config->{$config->name}
        ));
        
        $options = array();
        $options[] = $this->option(array('text' => JText::_( 'OHANAH_ASC' ) , 'value' => 'asc' ));
        $options[] = $this->option(array('text' => JText::_( 'OHANAH_DESC' ), 'value' => 'desc' ));
    
        //Add the options to the config object
        $config->options = $options;
        
        return $this->optionlist($config);
    }

    public function published_or_draft( $config = array())
    {
        $config = new KConfig($config);
        $config->append(array(
            'name'      => 'enabled',
            'attribs'   => array(),
            'deselect'  => true,
            'prompt'    => 'OHANAH_SELECT',
        ))->append(array(
            'selected'  => $config->{$config->name}
        ));
        
        $options = array();        
        $options[] = $this->option(array('text' => JText::_( 'Published' ) , 'value' => 1 ));
        $options[] = $this->option(array('text' => JText::_( 'OHANAH_DRAFT' ), 'value' => 0 ));
    
        //Add the options to the config object
        $config->options = $options;
        
        return $this->optionlist($config);
    }

    public function buttons_style( $config = array())
    {
        $config = new KConfig($config);
        $config->append(array(
            'name'      => 'buttons_style',
            'attribs'   => array(),
            'deselect'  => true,
            'prompt'    => 'OHANAH_SELECT',
        ))->append(array(
            'selected'  => $config->{$config->name}
        ));
        
        $options = array();        
        $options[] = $this->option(array('text' => 'Ohanah default', 'value' => 'ohanah'));
        $options[] = $this->option(array('text' => 'RocketTheme', 'value' => 'rockettheme'));
        $options[] = $this->option(array('text' => 'YooTheme', 'value' => 'yootheme'));
        $options[] = $this->option(array('text' => 'Gavick', 'value' => 'gavick'));
        $options[] = $this->option(array('text' => 'JoomlArt', 'value' => 'joomlart'));
        $options[] = $this->option(array('text' => 'Joomlabamboo', 'value' => 'joomlabamboo'));
        $options[] = $this->option(array('text' => 'JoomlaXtc', 'value' => 'joomlaxtc'));
        $options[] = $this->option(array('text' => JText::_('OHANAH_NO_THEME'), 'value' => 'none'));
    
        //Add the options to the config object
        $config->options = $options;
        
        return $this->optionlist($config);
    }

    public function filterevents( $config = array())
    {
        $config = new KConfig($config);
        $config->append(array(
            'name'      => 'filterEvents',
            'attribs'   => array(),
            'deselect'  => true,
            'prompt'    => 'OHANAH_SELECT',
        ))->append(array(
            'selected'  => $config->{$config->name}
        ));
        
        $options = array();        
        $options[] = $this->option(array('text' => JText::_( 'OHANAH_ALL_EVENTS' ) , 'value' => 'all' ));
        $options[] = $this->option(array('text' => JText::_( 'OHANAH_UPCOMING_EVENTS' ), 'value' => 'notpast' ));
        $options[] = $this->option(array('text' => JText::_( 'OHANAH_PAST_EVENTS' ), 'value' => 'past' ));
    
        //Add the options to the config object
        $config->options = $options;
        
        return $this->optionlist($config);
    }

    public function event_place_style( $config = array())
    {
        $config = new KConfig($config);
        $config->append(array(
            'name'      => 'event_place_style',
            'attribs'   => array(),
            'deselect'  => true,
            'prompt'    => 'OHANAH_SELECT',
        ))->append(array(
            'selected'  => $config->{$config->name}
        ));
        
        $options = array();        
        $options[] = $this->option(array('text' => JText::_( 'OHANAH_VENUE_NAME' ) , 'value' => 'venue' ));
        $options[] = $this->option(array('text' => JText::_( 'OHANAH_VENUE_NAME_AND_CITY' ) , 'value' => 'venue_and_city' ));
        $options[] = $this->option(array('text' => JText::_( 'OHANAH_ADDRESS' ) , 'value' => 'address' ));
        $options[] = $this->option(array('text' => JText::_( 'OHANAH_VENUE_AND_ADDRESS' ) , 'value' => 'venue_and_address' ));
        $options[] = $this->option(array('text' => JText::_( 'OHANAH_CITY_AND_COUNTRY' ) , 'value' => 'city_and_country' ));
        $options[] = $this->option(array('text' => JText::_( 'OHANAH_CITY_AND_STATE' ) , 'value' => 'city_and_state' ));
        $options[] = $this->option(array('text' => JText::_( 'OHANAH_CITY_AND_STATE_AND_COUNTRY' ) , 'value' => 'city_state_and_country' ));

        //Add the options to the config object
        $config->options = $options;
        
        return $this->optionlist($config);
    }


    public function currency( $config = array())
    {
        $config = new KConfig($config);
        $config->append(array(
            'name'      => 'payment_currency',
            'attribs'   => array(),
            'deselect'  => true,
            'prompt'    => 'OHANAH_SELECT',
        ))->append(array(
            'selected'  => $config->{$config->name}
        ));
        
        $options = array();       
        
        $option = new KObject(); $option->text = "USD"; $option->value="USD"; $options[] = $option;
        $option = new KObject(); $option->text = "EUR"; $option->value="EUR"; $options[] = $option;
        $option = new KObject(); $option->text = "GBP"; $option->value="GBP"; $options[] = $option;
        $option = new KObject(); $option->text = "CHF"; $option->value="CHF"; $options[] = $option;
        $option = new KObject(); $option->text = "CAD"; $option->value="CAD"; $options[] = $option;
        $option = new KObject(); $option->text = "JPY"; $option->value="JPY"; $options[] = $option;
        $option = new KObject(); $option->text = "AUD"; $option->value="AUD"; $options[] = $option;
        $option = new KObject(); $option->text = "BRL"; $option->value="BRL"; $options[] = $option;
        $option = new KObject(); $option->text = "CZK"; $option->value="CZK"; $options[] = $option;
        $option = new KObject(); $option->text = "DKK"; $option->value="DKK"; $options[] = $option;
        $option = new KObject(); $option->text = "HKD"; $option->value="HKD"; $options[] = $option;
        $option = new KObject(); $option->text = "HUF"; $option->value="HUF"; $options[] = $option;
        $option = new KObject(); $option->text = "ILS"; $option->value="ILS"; $options[] = $option;
        $option = new KObject(); $option->text = "JPY"; $option->value="JPY"; $options[] = $option;
        $option = new KObject(); $option->text = "MYR"; $option->value="MYR"; $options[] = $option;
        $option = new KObject(); $option->text = "MXN"; $option->value="MXN"; $options[] = $option;
        $option = new KObject(); $option->text = "NOK"; $option->value="NOK"; $options[] = $option;
        $option = new KObject(); $option->text = "NZD"; $option->value="NZD"; $options[] = $option;
        $option = new KObject(); $option->text = "PHP"; $option->value="PHP"; $options[] = $option;
        $option = new KObject(); $option->text = "PLN"; $option->value="PLN"; $options[] = $option;
        $option = new KObject(); $option->text = "SGD"; $option->value="SGD"; $options[] = $option;
        $option = new KObject(); $option->text = "SEK"; $option->value="SEK"; $options[] = $option;
        $option = new KObject(); $option->text = "TWD"; $option->value="TWD"; $options[] = $option;
        $option = new KObject(); $option->text = "THB"; $option->value="THB"; $options[] = $option;
        $option = new KObject(); $option->text = "TRY"; $option->value="TRY"; $options[] = $option;
        $option = new KObject(); $option->text = "AED&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Not supported by PayPal)"; $option->value="AED"; $options[] = $option;
        $option = new KObject(); $option->text = "HRK&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Not supported by PayPal)"; $option->value="HRK"; $options[] = $option;
        $option = new KObject(); $option->text = "INR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Not supported by PayPal)"; $option->value="INR"; $options[] = $option;
        $option = new KObject(); $option->text = "RON&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Not supported by PayPal)"; $option->value="RON"; $options[] = $option;
        $option = new KObject(); $option->text = "RSD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Not supported by PayPal)"; $option->value="RSD"; $options[] = $option;
        $option = new KObject(); $option->text = "RUB&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Not supported by PayPal)"; $option->value="RUB"; $options[] = $option;
        $option = new KObject(); $option->text = "VND&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Not supported by PayPal)"; $option->value="VND"; $options[] = $option;
        $option = new KObject(); $option->text = "ZAR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Not supported by PayPal)"; $option->value="ZAR"; $options[] = $option;
        $option = new KObject(); $option->text = "NGN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Not supported by PayPal)"; $option->value="NGN"; $options[] = $option;
        $option = new KObject(); $option->text = "KWD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Not supported by PayPal)"; $option->value="KWD"; $options[] = $option;
        $option = new KObject(); $option->text = "UAH&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Not supported by PayPal)"; $option->value="UAH"; $options[] = $option;

        //Add the options to the config object
        $config->options = $options;
        
        return $this->optionlist($config);
    }

    /* DEPRECATED, SHOULD BE DELETED IN NEXT RELEASE */
    public function time( $config = array())
    {
        $config = new KConfig($config);
        $config->append(array(
            'name'      => 'enabled',
            'attribs'   => array(),
            'deselect'  => true,
            'prompt'    => 'OHANAH_SELECT',
        ))->append(array(
            'selected'  => $config->{$config->name}
        ));
        
        $options = array();       
        
        if (JComponentHelper::getParams('com_ohanah')->get('timeFormat') == '1') {
            $options[] = $this->option(array('text' => JText::_('12:00 AM') , 'value' => '00:00' ));
            $options[] = $this->option(array('text' => JText::_('12:30 AM') , 'value' => '00:30' ));
            $options[] = $this->option(array('text' => JText::_('1:00 AM') , 'value' => '01:00' ));
            $options[] = $this->option(array('text' => JText::_('1:30 AM') , 'value' => '01:30' ));
            $options[] = $this->option(array('text' => JText::_('2:00 AM') , 'value' => '02:00' ));
            $options[] = $this->option(array('text' => JText::_('2:30 AM') , 'value' => '02:30' ));
            $options[] = $this->option(array('text' => JText::_('3:00 AM') , 'value' => '03:00' ));
            $options[] = $this->option(array('text' => JText::_('3:30 AM') , 'value' => '03:30' ));
            $options[] = $this->option(array('text' => JText::_('4:00 AM') , 'value' => '04:00' ));
            $options[] = $this->option(array('text' => JText::_('4:30 AM') , 'value' => '04:30' ));
            $options[] = $this->option(array('text' => JText::_('5:00 AM') , 'value' => '05:00' ));
            $options[] = $this->option(array('text' => JText::_('5:30 AM') , 'value' => '05:30' ));
            $options[] = $this->option(array('text' => JText::_('6:00 AM') , 'value' => '06:00' ));
            $options[] = $this->option(array('text' => JText::_('6:30 AM') , 'value' => '06:30' ));
            $options[] = $this->option(array('text' => JText::_('7:00 AM') , 'value' => '07:00' ));
            $options[] = $this->option(array('text' => JText::_('7:30 AM') , 'value' => '07:30' ));
            $options[] = $this->option(array('text' => JText::_('8:00 AM') , 'value' => '08:00' ));
            $options[] = $this->option(array('text' => JText::_('8:30 AM') , 'value' => '08:30' ));
            $options[] = $this->option(array('text' => JText::_('9:00 AM') , 'value' => '09:00' ));
            $options[] = $this->option(array('text' => JText::_('9:30 AM') , 'value' => '09:30' ));
            $options[] = $this->option(array('text' => JText::_('10:00 AM') , 'value' => '10:00' ));
            $options[] = $this->option(array('text' => JText::_('10:30 AM') , 'value' => '10:30' ));
            $options[] = $this->option(array('text' => JText::_('11:00 AM') , 'value' => '11:00' ));
            $options[] = $this->option(array('text' => JText::_('11:30 AM') , 'value' => '11:30' ));
            $options[] = $this->option(array('text' => JText::_('12:00 PM') , 'value' => '12:00' ));
            $options[] = $this->option(array('text' => JText::_('12:30 PM') , 'value' => '12:30' ));
            $options[] = $this->option(array('text' => JText::_('1:00 PM') , 'value' => '13:00' ));
            $options[] = $this->option(array('text' => JText::_('1:30 PM') , 'value' => '13:30' ));
            $options[] = $this->option(array('text' => JText::_('2:00 PM') , 'value' => '14:00' ));
            $options[] = $this->option(array('text' => JText::_('2:30 PM') , 'value' => '14:30' ));
            $options[] = $this->option(array('text' => JText::_('3:00 PM') , 'value' => '15:00' ));
            $options[] = $this->option(array('text' => JText::_('3:30 PM') , 'value' => '15:30' ));
            $options[] = $this->option(array('text' => JText::_('4:00 PM') , 'value' => '16:00' ));
            $options[] = $this->option(array('text' => JText::_('4:30 PM') , 'value' => '16:30' ));
            $options[] = $this->option(array('text' => JText::_('5:00 PM') , 'value' => '17:00' ));
            $options[] = $this->option(array('text' => JText::_('5:30 PM') , 'value' => '17:30' ));
            $options[] = $this->option(array('text' => JText::_('6:00 PM') , 'value' => '18:00' ));
            $options[] = $this->option(array('text' => JText::_('6:30 PM') , 'value' => '18:30' ));
            $options[] = $this->option(array('text' => JText::_('7:00 PM') , 'value' => '19:00' ));
            $options[] = $this->option(array('text' => JText::_('7:30 PM') , 'value' => '19:30' ));
            $options[] = $this->option(array('text' => JText::_('8:00 PM') , 'value' => '20:00' ));
            $options[] = $this->option(array('text' => JText::_('8:30 PM') , 'value' => '20:30' ));
            $options[] = $this->option(array('text' => JText::_('9:00 PM') , 'value' => '21:00' ));
            $options[] = $this->option(array('text' => JText::_('9:30 PM') , 'value' => '21:30' ));
            $options[] = $this->option(array('text' => JText::_('10:00 PM') , 'value' => '22:00' ));
            $options[] = $this->option(array('text' => JText::_('10:30 PM') , 'value' => '22:30' ));
            $options[] = $this->option(array('text' => JText::_('11:00 PM') , 'value' => '23:00' ));
            $options[] = $this->option(array('text' => JText::_('11:30 PM') , 'value' => '23:30' ));
        } else {
            $options[] = $this->option(array('text' => JText::_('00:00') , 'value' => '00:00' ));
            $options[] = $this->option(array('text' => JText::_('00:30') , 'value' => '00:30' ));
            $options[] = $this->option(array('text' => JText::_('01:00') , 'value' => '01:00' ));
            $options[] = $this->option(array('text' => JText::_('01:30') , 'value' => '01:30' ));
            $options[] = $this->option(array('text' => JText::_('02:00') , 'value' => '02:00' ));
            $options[] = $this->option(array('text' => JText::_('02:30') , 'value' => '02:30' ));
            $options[] = $this->option(array('text' => JText::_('03:00') , 'value' => '03:00' ));
            $options[] = $this->option(array('text' => JText::_('03:30') , 'value' => '03:30' ));
            $options[] = $this->option(array('text' => JText::_('04:00') , 'value' => '04:00' ));
            $options[] = $this->option(array('text' => JText::_('04:30') , 'value' => '04:30' ));
            $options[] = $this->option(array('text' => JText::_('05:00') , 'value' => '05:00' ));
            $options[] = $this->option(array('text' => JText::_('05:30') , 'value' => '05:30' ));
            $options[] = $this->option(array('text' => JText::_('06:00') , 'value' => '06:00' ));
            $options[] = $this->option(array('text' => JText::_('06:30') , 'value' => '06:30' ));
            $options[] = $this->option(array('text' => JText::_('07:00') , 'value' => '07:00' ));
            $options[] = $this->option(array('text' => JText::_('07:30') , 'value' => '07:30' ));
            $options[] = $this->option(array('text' => JText::_('08:00') , 'value' => '08:00' ));
            $options[] = $this->option(array('text' => JText::_('08:30') , 'value' => '08:30' ));
            $options[] = $this->option(array('text' => JText::_('09:00') , 'value' => '09:00' ));
            $options[] = $this->option(array('text' => JText::_('09:30') , 'value' => '09:30' ));
            $options[] = $this->option(array('text' => JText::_('10:00') , 'value' => '10:00' ));
            $options[] = $this->option(array('text' => JText::_('10:30') , 'value' => '10:30' ));
            $options[] = $this->option(array('text' => JText::_('11:00') , 'value' => '11:00' ));
            $options[] = $this->option(array('text' => JText::_('11:30') , 'value' => '11:30' ));
            $options[] = $this->option(array('text' => JText::_('12:00') , 'value' => '12:00' ));
            $options[] = $this->option(array('text' => JText::_('12:30') , 'value' => '12:30' ));
            $options[] = $this->option(array('text' => JText::_('13:00') , 'value' => '13:00' ));
            $options[] = $this->option(array('text' => JText::_('13:30') , 'value' => '13:30' ));
            $options[] = $this->option(array('text' => JText::_('14:00') , 'value' => '14:00' ));
            $options[] = $this->option(array('text' => JText::_('14:30') , 'value' => '14:30' ));
            $options[] = $this->option(array('text' => JText::_('15:00') , 'value' => '15:00' ));
            $options[] = $this->option(array('text' => JText::_('15:30') , 'value' => '15:30' ));
            $options[] = $this->option(array('text' => JText::_('16:00') , 'value' => '16:00' ));
            $options[] = $this->option(array('text' => JText::_('16:30') , 'value' => '16:30' ));
            $options[] = $this->option(array('text' => JText::_('17:00') , 'value' => '17:00' ));
            $options[] = $this->option(array('text' => JText::_('17:30') , 'value' => '17:30' ));
            $options[] = $this->option(array('text' => JText::_('18:00') , 'value' => '18:00' ));
            $options[] = $this->option(array('text' => JText::_('18:30') , 'value' => '18:30' ));
            $options[] = $this->option(array('text' => JText::_('19:00') , 'value' => '19:00' ));
            $options[] = $this->option(array('text' => JText::_('19:30') , 'value' => '19:30' ));
            $options[] = $this->option(array('text' => JText::_('20:00') , 'value' => '20:00' ));
            $options[] = $this->option(array('text' => JText::_('20:30') , 'value' => '20:30' ));
            $options[] = $this->option(array('text' => JText::_('21:00') , 'value' => '21:00' ));
            $options[] = $this->option(array('text' => JText::_('21:30') , 'value' => '21:30' ));
            $options[] = $this->option(array('text' => JText::_('22:00') , 'value' => '22:00' ));
            $options[] = $this->option(array('text' => JText::_('22:30') , 'value' => '22:30' ));
            $options[] = $this->option(array('text' => JText::_('23:00') , 'value' => '23:00' ));
            $options[] = $this->option(array('text' => JText::_('23:30') , 'value' => '23:30' ));
        }
        //Add the options to the config object
        $config->options = $options;
        
        return $this->optionlist($config);
    }

    public function timeH( $config = array())
    {
        $config = new KConfig($config);
        $config->append(array(
            'name'      => 'enabled',
            'attribs'   => array(),
            'deselect'  => true,
            'prompt'    => 'OHANAH_SELECT',
        ))->append(array(
            'selected'  => $config->{$config->name}
        ));
        
        $options = array();       
        
        if (JComponentHelper::getParams('com_ohanah')->get('timeFormat') == '1') {
            
            $options[] = $this->option(array('text' => JText::_('12') , 'value' => '12' ));
            $options[] = $this->option(array('text' => JText::_('01') , 'value' => '01' ));
            $options[] = $this->option(array('text' => JText::_('02') , 'value' => '02' ));
            $options[] = $this->option(array('text' => JText::_('03') , 'value' => '03' ));
            $options[] = $this->option(array('text' => JText::_('04') , 'value' => '04' ));
            $options[] = $this->option(array('text' => JText::_('05') , 'value' => '05' ));
            $options[] = $this->option(array('text' => JText::_('06') , 'value' => '06' ));
            $options[] = $this->option(array('text' => JText::_('07') , 'value' => '07' ));
            $options[] = $this->option(array('text' => JText::_('08') , 'value' => '08' ));
            $options[] = $this->option(array('text' => JText::_('09') , 'value' => '09' ));
            $options[] = $this->option(array('text' => JText::_('10') , 'value' => '10' ));
            $options[] = $this->option(array('text' => JText::_('11') , 'value' => '11' ));

        } else {
            $options[] = $this->option(array('text' => JText::_('00') , 'value' => '00' ));
            $options[] = $this->option(array('text' => JText::_('01') , 'value' => '01' ));
            $options[] = $this->option(array('text' => JText::_('02') , 'value' => '02' ));
            $options[] = $this->option(array('text' => JText::_('03') , 'value' => '03' ));
            $options[] = $this->option(array('text' => JText::_('04') , 'value' => '04' ));
            $options[] = $this->option(array('text' => JText::_('05') , 'value' => '05' ));
            $options[] = $this->option(array('text' => JText::_('06') , 'value' => '06' ));
            $options[] = $this->option(array('text' => JText::_('07') , 'value' => '07' ));
            $options[] = $this->option(array('text' => JText::_('08') , 'value' => '08' ));
            $options[] = $this->option(array('text' => JText::_('09') , 'value' => '09' ));
            $options[] = $this->option(array('text' => JText::_('10') , 'value' => '10' ));
            $options[] = $this->option(array('text' => JText::_('11') , 'value' => '11' ));
            $options[] = $this->option(array('text' => JText::_('12') , 'value' => '12' ));
            $options[] = $this->option(array('text' => JText::_('13') , 'value' => '13' ));
            $options[] = $this->option(array('text' => JText::_('14') , 'value' => '14' ));
            $options[] = $this->option(array('text' => JText::_('15') , 'value' => '15' ));
            $options[] = $this->option(array('text' => JText::_('16') , 'value' => '16' ));
            $options[] = $this->option(array('text' => JText::_('17') , 'value' => '17' ));
            $options[] = $this->option(array('text' => JText::_('18') , 'value' => '18' ));
            $options[] = $this->option(array('text' => JText::_('19') , 'value' => '19' ));
            $options[] = $this->option(array('text' => JText::_('20') , 'value' => '20' ));
            $options[] = $this->option(array('text' => JText::_('21') , 'value' => '21' ));
            $options[] = $this->option(array('text' => JText::_('22') , 'value' => '22' ));
            $options[] = $this->option(array('text' => JText::_('23') , 'value' => '23' ));
        }
        //Add the options to the config object
        $config->options = $options;
        
        return $this->optionlist($config);
    }

    public function timeM( $config = array())
    {
        $config = new KConfig($config);
        $config->append(array(
            'name'      => 'enabled',
            'attribs'   => array(),
            'deselect'  => true,
            'prompt'    => 'OHANAH_SELECT',
        ))->append(array(
            'selected'  => $config->{$config->name}
        ));
        
        $options = array();       
        
        $options[] = $this->option(array('text' => JText::_('00') , 'value' => '00' ));
        $options[] = $this->option(array('text' => JText::_('15') , 'value' => '15' ));
        $options[] = $this->option(array('text' => JText::_('30') , 'value' => '30' ));
        $options[] = $this->option(array('text' => JText::_('45') , 'value' => '45' ));

        //Add the options to the config object
        $config->options = $options;
        
        return $this->optionlist($config);
    }

    public function timeAMPM( $config = array())
    {
        $config = new KConfig($config);
        $config->append(array(
            'name'      => 'enabled',
            'attribs'   => array(),
            'deselect'  => true,
            'prompt'    => 'OHANAH_SELECT',
        ))->append(array(
            'selected'  => $config->{$config->name}
        ));
        
        $options = array();       
        
        $options[] = $this->option(array('text' => JText::_('AM') , 'value' => 'AM' ));
        $options[] = $this->option(array('text' => JText::_('PM') , 'value' => 'PM' ));

        //Add the options to the config object
        $config->options = $options;
        
        return $this->optionlist($config);
    }

    public function module_chrome($config = array())
    {
        $root = JPATH_SITE;
        $path = $root.'/templates/';
        $options = array();

        foreach(JFolder::folders($path) as $template)
        {
            if (substr($template, 0, 4) == 'yoo_') {
                $options[] = $this->option(array('text' => $template , 'value' => $template, 'disable' => 'yes' ));    
                $options[] = $this->option(array('text' => 'For Yootheme templates use system chromes', 'value' => '', 'disable' => 'yes' ));
                continue;
            }

            $chromes = $this->_searchTemplate($template, $path);
            if(!$chromes) continue;

            $options[] = $this->option(array('text' => $template , 'value' => $template, 'disable' => 'yes' ));    

            foreach($chromes as $chrome)
            {
                $options[] = $this->option(array('text' => $chrome , 'value' => $chrome ));    
            }
        }
        
        $config = new KConfig($config);
        $config->append(array(
            'name'      => 'module_chrome',
        ))->append(array(
            'selected'  => $config->{$config->name}
        ));
        $config->options = $options;
        
        return $this->optionlist($config);
    }

    public function module_positions($config = array())
    {
        jimport('joomla.filesystem.folder');       

        $options = array();

        $config = new KConfig($config);
        
        foreach($config->positions as $position)
        {
            $options[] = $this->option(array('text' => $position , 'value' => $position ));    
        }
        
        $config->append(array(
            'name'      => $config->{$config->name},
        ))->append(array(
            'selected'  => $config->{$config->name}
        ));
        $config->options = $options;
        
        return $this->optionlist($config);
    }
    
    public function getModulePositions() {

        //Get the database object
        $db =& JFactory::getDBO();

        $templates = null;

        $joomlaVersion = JVersion::isCompatible('1.6.0') ? '1.6' : '1.5';
        if ($joomlaVersion != '1.5') { 

            $query = 'SELECT DISTINCT(template) AS text, template AS value'.
                    ' FROM #__template_styles' .
                    ' WHERE client_id = 0';
            $db->setQuery( $query );
            $templates = $db->loadObjectList();
        } else {
            
            $query = 'SELECT DISTINCT(template) AS text, template AS value'.
                    ' FROM #__templates_menu' .
                    ' WHERE client_id = 0';
            $db->setQuery( $query );
            $templates = $db->loadObjectList();
        }

        // Get a list of all module positions as set in the database
        $query = 'SELECT DISTINCT(position)'.
                ' FROM #__modules' .
                ' WHERE client_id = 0';
        $db->setQuery( $query );
        $positions = $db->loadResultArray();
        $positions = (is_array($positions)) ? $positions : array();

        // Get a list of all template xml files for a given application

        // Get the xml parser first
        for ($i = 0, $n = count($templates); $i < $n; $i++ )
        {
            $path = JPATH_ROOT.DS.'templates'.DS.$templates[$i]->value;

            $xml =& JFactory::getXMLParser('Simple');

            if ($xml->loadFile($path.DS.'templateDetails.xml'))
            {
                $p =& $xml->document->getElementByPath('positions');
                if (is_a($p, 'JSimpleXMLElement') && count($p->children()))
                {
                    foreach ($p->children() as $child)
                    {
                        if (!in_array($child->data(), $positions)) {
                            $positions[] = $child->data();

                        }
                    }
                }
            }
        }

        if(defined('_JLEGACY') && _JLEGACY == '1.0')
        {
            $positions[] = 'left';
            $positions[] = 'right';
            $positions[] = 'top';
            $positions[] = 'bottom';
            $positions[] = 'inset';
            $positions[] = 'banner';
            $positions[] = 'header';
            $positions[] = 'footer';
            $positions[] = 'newsflash';
            $positions[] = 'legals';
            $positions[] = 'pathway';
            $positions[] = 'breadcrumb';
            $positions[] = 'user1';
            $positions[] = 'user2';
            $positions[] = 'user3';
            $positions[] = 'user4';
            $positions[] = 'user5';
            $positions[] = 'user6';
            $positions[] = 'user7';
            $positions[] = 'user8';
            $positions[] = 'user9';
            $positions[] = 'advert1';
            $positions[] = 'advert2';
            $positions[] = 'advert3';
            $positions[] = 'debug';
            $positions[] = 'syndicate';
        }

        $positions = array_unique($positions);
        sort($positions);


        return $positions;
    }
    
    protected function _searchTemplate($template, $path)
    {
        //$fileData  = JFile::read(JPATH_ROOT.DS.'templates'.DS.'system'.DS.'html'.DS.'modules.php', false, 0, filesize(JPATH_ROOT.DS.'templates'.DS.$template->template.DS.'html'.DS.'modules.php'));
        if(!file_exists($path.$template.DS.'html'.DS.'modules.php')) return array();
        $fileData = JFile::read($path.$template.DS.'html'.DS.'modules.php', false, 0, filesize($path.$template.DS.'html'.DS.'modules.php'));
        
        preg_match_all("/function(.)modChrome_(.*?)\(/", $fileData, $matches);
    
        return $matches['2'];
    }
}