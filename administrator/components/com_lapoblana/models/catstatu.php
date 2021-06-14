<?php
/** 
 * fecha: 19-11-13
 * company: company
 * @author Karlos
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.model');

class LapoblanaModelCatstatu extends JModelLegacy{
                                
        public function insertStatus($statusName, $active, $dateCreation){                                                                       
            $db = JFactory::getDbo();                                        
            $query = "INSERT INTO #__cat_statuslp (statusName, active, dateCreation) 
                     VALUES ('$statusName', '$active', '$dateCreation')";              
            $db->setQuery($query);
            $db->query();                 
            $id = $db->insertid();                
            return $id;
        }
        
        public function updateStatus($statusName, $active, $idUrl){           
           $db =& JFactory::getDBO();                                        
            $query = "UPDATE #__cat_statuslp SET statusName='$statusName', active='$active'
                     WHERE statusId = $idUrl ";              
           $db->setQuery($query);                     
           $db->query();  
        } 
        
        public function getDataStatus($idStatus){                      
           
           if($idStatus>0){ 
            //ir a la tabla cat_products para traer todos sus datos dependiendo de su id                           
            $db = JFactory::getDbo();                
            $query = "
                        SELECT a.*
                        FROM #__cat_statuslp as a                        
                        WHERE a.statusId=$idStatus
                      ";       
            $db->setQuery($query);
            $db->query();
            $rows = $db->loadObjectList();                                                                                
           }
           else{
                $rows = array();  
           }
           
           return $rows;
       }
        
}

?>
