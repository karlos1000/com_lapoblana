<?php
/** 
 * fecha: 19-11-13
 * company: company
 * @author Karlos
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.modellist');
 
class LapoblanaModelCatdrawings extends JModelList{
       
        public function getItems()
	{
            
            if (!isset($this->items))
            {
                $limitstart = $this->getState('list.start');                
		$limit = $this->getState('list.limit');    
                                                      
                $this->userC = JFactory::getUser();
                $this->groups = JAccess::getGroupsByUser($this->userC->id, false);                                            
                $this->strgroupsCurrent = implode(",", $this->groups); 
            
                $db = JFactory::getDbo();                                                
                $query = "
                        SELECT a.*
                        FROM #__cat_drawingslp as a                        
                      ";                                                           
                $db->setQuery($query);
                $db->query();    
                $rows = $db->loadObjectList();                      
                
                $this->total = count($rows);
                if ($limitstart >= $this->total) {
                        $limitstart = $limitstart < $limit ? 0 : $limitstart - $limit;
                        $this->setState('list.start', $limitstart);
                }
                
                $this->items = array_slice($rows, $limitstart, $limit ? $limit : null);
                
            }
            return $this->items;                                  								                
	}

	/**
	 * Method to get the total number of items.
	 *
	 * @return	int	The total number of items.
	 * @since	1.6
	 */
	public function getTotal()
	{
		if (!isset($this->total))
		{
			$this->getItems();
		}
		return $this->total;             
	}        
         
        
        public function updateActiveByIdDrawing($idsDrawings,$checkvalactive){
           $db = JFactory::getDbo();
           $ids = implode(',', $idsDrawings);
           $query = "UPDATE #__cat_drawingslp 
                     SET active = $checkvalactive
                     WHERE drawingId IN ($ids) ";
           $db->setQuery($query);
           $db->query();              
       }
        
//        public function deleteDrawingById($idsDrawings){
//             $db = JFactory::getDbo();            
//             foreach($idsDrawings as $idP):    
//                 $query = " DELETE FROM #__cat_drawingslp  
//                            WHERE drawingId IN ($idP) ";
//                 $db->setQuery($query);
//                 $result[] = $db->query();                    
//             endforeach;
//             return $result;
//        }                
       
        
        public function deleteDrawingById($idsDrawings){
             $db = JFactory::getDbo();            
             foreach($idsDrawings as $id):
                                  
                 $querySearch = " SELECT * FROM #__productslp WHERE prodDrawing IN ($id) ";                            
                 $db->setQuery($querySearch);
                 $db->query();                                     
                 $rows = $db->loadResult();
                 
                 $nameDrawing=$this->getDrawingName($id);
                 if($rows!=null){
                     $resultNoDel[] = $nameDrawing;
                 }else{
                     $query = " DELETE FROM #__cat_drawingslp  
                            WHERE drawingId IN ($id) ";
                     $db->setQuery($query);
                     $db->query();                      
                     
                     $result[] = $nameDrawing;
                 }
                                                                    
             endforeach;
             return  array('notDelete'=>$resultNoDel,'deleted'=>$result); 
        }
                               
        //obtener nombre del dinujo
        public function getDrawingName($id){
            $db = JFactory::getDbo(); 
            $querySearch = " SELECT drawingName	FROM #__cat_drawingslp WHERE drawingId=$id ";                            
            $db->setQuery($querySearch);
            $db->query();                                     
            $drawName = $db->loadResult();
            
            return $drawName;
        }
}

?>
