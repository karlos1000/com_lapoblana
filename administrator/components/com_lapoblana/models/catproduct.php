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

class LapoblanaModelCatproduct extends JModelLegacy{
                                
        public function insertProduct($productName, $active, $dateCreation){                                                                       
            $db = JFactory::getDbo();                                        
            $query = "INSERT INTO #__cat_productslp (productName, active, dateCreation) 
                     VALUES ('$productName', '$active', '$dateCreation')";              
            $db->setQuery($query);
            $db->query();                 
            $id = $db->insertid();                
            return $id;
        }
        
        public function updateProduct($productName, $active, $idUrl){           
           $db =& JFactory::getDBO();                                        
            $query = "UPDATE #__cat_productslp SET productName='$productName', active='$active'
                     WHERE productId = $idUrl ";              
           $db->setQuery($query);                     
           $db->query();  
        } 
        
        public function getDataProduct($idProduct){                      
           
           if($idProduct>0){ 
            //ir a la tabla cat_products para traer todos sus datos dependiendo de su id                           
            $db = JFactory::getDbo();                
            $query = "
                        SELECT a.*
                        FROM #__cat_productslp as a                        
                        WHERE a.productId=$idProduct
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
