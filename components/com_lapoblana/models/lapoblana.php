<?php

/** 
 * fecha: 23-06-14
 * company: company
 * @author Karlos
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
 
/**
 * Modelo Lapoblana
 */

class LapoblanaModelLapoblana extends JModelItem{
    
    /**
         * @var array messages
         */
        protected $messages; 
        
        public function getTable($type = 'Lapoblana', $prefix = 'LapoblanaTable', $config = array()) 
        {
                return JTable::getInstance($type, $prefix, $config);
        }
        
        public function getMsg($id = 1) 
        {
                if (!is_array($this->messages))
                {
                        $this->messages = array();
                }
 
                if (!isset($this->messages[$id])) 
                {
                    
                        $jinput = JFactory::getApplication()->input;                        
                        $id = $jinput->get('id', 1, 'INT' );
 
                        // Get a Lapoblana instance
                        $table = $this->getTable();
 
                        // Load the message
                        $table->load($id);
 
                        // Assign the message
                        $this->messages[$id] = $table->greeting;
                }
 
                return $this->messages[$id];
        }
}

?>
