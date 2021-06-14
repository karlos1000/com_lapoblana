<?php
/** 
 * fecha: 23-06-14
 * company: company
 * @author Karlos
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');

class LapoblanaModelLapoblana extends JModelList{
    
        protected function getListQuery()
        {
                // Create a new query object.           
                $db = JFactory::getDBO();
                $query = $db->getQuery(true);
                // Select some fields
                $query->select('id,greeting');
                // From the lapoblana table
                $query->from('#__lapoblana');
                return $query;
        }               
}

?>
