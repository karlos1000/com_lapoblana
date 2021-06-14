<?php
/** 
 * fecha: 23-06-14
 * company: company
 * @author Karlos
 */
// No direct access
defined('_JEXEC') or die('Restricted access');
// import Joomla table library
jimport('joomla.database.table');
 
class LapoblanaTableLapoblana extends JTable {
    
        /**
         * Constructor
         *
         * @param object Database connector object
         */
        function __construct(&$db) 
        {
                parent::__construct('#__lapoblana', 'id', $db);
        }
}

?>
