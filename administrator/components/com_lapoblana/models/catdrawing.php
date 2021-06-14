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

class LapoblanaModelCatdrawing extends JModelLegacy{
                                
        public function insertDrawing($drawingName, $active, $dateCreation){                                                                       
            $db = JFactory::getDbo();                                        
            $query = "INSERT INTO #__cat_drawingslp (drawingName, active, dateCreation) 
                     VALUES ('$drawingName', '$active', '$dateCreation')";              
            $db->setQuery($query);
            $db->query();                 
            $id = $db->insertid();                
            return $id;
        }
        
        public function updateDrawing($drawingName, $active, $idUrl){           
           $db =& JFactory::getDBO();                                        
            $query = "UPDATE #__cat_drawingslp SET drawingName='$drawingName', active='$active'
                     WHERE drawingId = $idUrl ";              
           $db->setQuery($query);                     
           $db->query();  
        } 
        
        public function getDataDrawing($idDrawing){                      
           
           if($idDrawing>0){ 
            //ir a la tabla cat_drawingslp para traer todos sus datos dependiendo de su id                           
            $db = JFactory::getDbo();                
            $query = "
                        SELECT a.*
                        FROM #__cat_drawingslp as a                        
                        WHERE a.drawingId=$idDrawing
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
