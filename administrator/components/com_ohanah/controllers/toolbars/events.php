<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php 
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

class ComOhanahControllerToolbarEvents extends ComOhanahControllerToolbarDefault
{
    public function getCommands()
    {
        $this->addSeparator()
            ->addCopy()
            ->addSeparator()
            ->addPublish()
        	->addUnpublish()
			->setTitle('OHANAH_EVENTS_LIST', 'dashboard')
			->setIcon('ohanah');

        $state = $this->getController()->getModel()->getState();

        if ($state->filterEvents == 'notpast' || $state->filterEvents == '') $title = JText::_('OHANAH_UPCOMING_EVENTS').' ';;
        if ($state->filterEvents == 'past') $title = JText::_('OHANAH_PAST_EVENTS').' ';
        if ($state->published == 'true') $title = JText::_('OHANAH_PUBLISHED_EVENTS').' ';
        if ($state->published == 'false') $title = JText::_('OHANAH_UNPUBLISHED_EVENTS').' ';
        if ($state->published == 'false' && $state->frontend_submitted == 1) $title = JText::_('OHANAH_FRONTEND_SUBMITTED_EVENTS').' ';

        if ($state->recurringParent) {
            $title = JText::sprintf('OHANAH_RECURRING_EVENT', $this->getService('com://admin/ohanah.model.events')->id($state->recurringParent)->getItem()->title);
        }

        if ($state->ohanah_venue_id) {
            $title .= JText::sprintf('OHANAH_IN_VENUE', $this->getService('com://admin/ohanah.model.venues')->id($state->ohanah_venue_id)->getItem()->title);
        }
        
        if ($state->ohanah_category_id) {
            $title .= ' '.JText::sprintf('OHANAH_IN_CATEGORY', $this->getService('com://admin/ohanah.model.categories')->id($state->ohanah_category_id)->getItem()->title);
        }

        $this->setTitle($title, 'dashboard');

        return parent::getCommands();
    }
}