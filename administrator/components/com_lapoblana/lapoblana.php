<?php
/** 
 * fecha: 23-06-14
 * company: company
 * @author Karlos
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_lapoblana')) {
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

// import joomla controller library
jimport('joomla.application.component.controller');

// Set some global property
$document = JFactory::getDocument();
$document->addStyleSheet('../media/com_lapoblana/css/style.css');
$document->addStyleDeclaration('.icon-48-lapoblana {background-image: url(../media/com_lapoblana/images/sistema.png);}');

// Get an instance of the controller prefixed by Lapoblana
//$controller = JController::getInstance('Lapoblana');
$controller = JControllerLegacy::getInstance('Lapoblana');
 
// Get the task
$jinput = JFactory::getApplication()->input;
$task = $jinput->get('task', "", 'STR' );
 
// Perform the Request task
$controller->execute($task);

// Redirect if set by the controller
$controller->redirect();

?>