<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php 
/**
 * @package		com_ohanah
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

class ComOhanahControllerToolbarRegistrations extends ComOhanahControllerToolbarDefault
{
    protected function _commandCancel(KControllerToolbarCommand $command)
    {
        $command->label = 'OHANAH_BUTTON_CLOSE';

        if (KRequest::get('get.layout', 'string') == 'sendmail') {
            $command->append(array('attribs' => array('href' =>  JRoute::_('index.php?option=com_ohanah&view=registrations&id=&ohanah_event_id='.KRequest::get('get.ohanah_event_id', 'int')))));
        } else {
            $command->append(array('attribs' => array('href' =>  JRoute::_('index.php?option=com_ohanah&view=events'))));
        }
    }

	public function getCommands()
    {
		$event = $this->getService('com://admin/ohanah.model.event')->set('id', KRequest::get('get.ohanah_event_id', 'int'))->getItem();
	
        if (KRequest::get('get.layout', 'string') == 'sendmail') {
            $this->reset()
                 ->addSendthemails()
                 ->addSeparator()
                 ->addCancel()
                 ->setTitle('OHANAH_WRITE_AN_EMAIL', 'dashboard')
                 ->setIcon('ohanah');
        } else {

            $this->reset()
                 ->addNew()
                 ->addDelete()
                 ->addSeparator()
                 ->addPaid()
                 ->addSeparator()
                 ->addSendmail()
                 ->addSeparator()
                 ->addCsv()
                 ->addSeparator()
                 ->addCancel()
                 ->setTitle(JText::sprintf('OHANAH_REGISTRATIONS_TO_THE_EVENT', $event->title), 'dashboard')
                 ->setIcon('ohanah');
        }
        return parent::getCommands();
    }

    protected function _commandSendthemails(KControllerToolbarCommand $command)
    {
        $command->label = 'OHANAH_SEND_THE_EMAIL';
        $command->append(array('attribs' => array('data-action' => 'sendEmail')));
    }

    protected function _commandCsv(KControllerToolbarCommand $command)
    {
        $command->label = 'OHANAH_EXPORT_AS_CSV';
        $command->append(array('attribs' => array('href' =>  JRoute::_('index.php?option=com_ohanah&view=registrations&ohanah_event_id='.KRequest::get('get.ohanah_event_id', 'int').'&format=csv'))));
    }

    protected function _commandSendmail(KControllerToolbarCommand $command)
    {
        $command->label = 'OHANAH_EMAIL';
        $command->append(array('attribs' => array('data-action' => 'composeMail')));
    }    

    protected function _commandNew(KControllerToolbarCommand $command)
    {
        $command->append(array('attribs' => array('href' =>  JRoute::_('index.php?option=com_ohanah&view=registration&ohanah_event_id='.KRequest::get('get.ohanah_event_id', 'int')))));
    }

    protected function _commandPaid(KControllerToolbarCommand $command)
    {
        $command->label = 'OHANAH_SET_AS_PAID';
        $command->append(array('attribs' => array('data-action' => 'edit', 'data-data'   => '{paid:1}')));
    }
    
    protected function _commandUnpaid(KControllerToolbarCommand $command) 
    {
        $command->append(array('attribs' => array('data-action' => 'edit', 'data-data'   => '{paid:0}')));
    }
}