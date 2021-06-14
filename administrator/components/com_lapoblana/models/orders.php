<?php
/** 
 * fecha: 19-11-13
 * company: company
 * @author Karlos
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.modellist');
 
class LapoblanaModelOrders extends JModelList{
       
        public function __construct($config = array())
        {   
                $config['filter_fields'] = array(
                        'idOrder',
                        'orderNum',                        
                        'idCustomer',
                        'dateOrder',
                        'dateReceipt',
                        'weeks',
                        'dateEstimated',
                );
                parent::__construct($config);                               
        }
        
        protected function populateState($ordering = null, $direction = null) {
            // Initialise variables.
            $app = JFactory::getApplication('administrator');
                
            // Adjust the context to support modal layouts.
            if ($layout = JRequest::getVar('layout', 'default'))
            {
                    $this->context .= '.'.$layout;
            }
               
            $search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
            $this->setState('filter.search', $search);
                                                                                                                                                                                                              
            //Load the parameters.
            $params = JComponentHelper::getParams('com_lapoblana');
            $this->setState('params', $params);

            // List state information.
            parent::populateState('id', 'asc');
        }
               
        public function getItems()
	{
                        
            if (!isset($this->items))
            {
                $search	= $this->getState('filter.search');		
                $ordering = $this->getState('list.ordering');
                $direction = $this->getState('list.direction');
                $limitstart = $this->getState('list.start');                
		$limit = $this->getState('list.limit');    
                                                      
                $this->userC = JFactory::getUser();
                $this->groups = JAccess::getGroupsByUser($this->userC->id, false);                                            
                $this->strgroupsCurrent = implode(",", $this->groups); 
            
                $db = JFactory::getDbo();                                                
                //ver solo los elementos a los cuales tiene permiso y estes en estado de activos WHERE a.active=1                
                if($search){                    
                     //Compile the different search clauses.
                    $search = str_replace("'","",$search);  //limpia el caracter ' de la cadena                  
                    
                    //si es fecha valida entonces entra
                    if(preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $search)) {                        
                        list($d,$m,$y) = explode('/', $search);
                        $search = $y.'-'.$m.'-'.$d;
                    }
                    
                    $searches	= array();                                        
                    $searches[] = "a.orderNum LIKE '%$search%' "; //Buscar por numero de orden
                    $searches[] = "a.idCustomer LIKE '%$search%' "; //Buscar por id de cliente
                    $searches[] = "a.dateOrder LIKE '%$search%' "; //Buscar por fecha de orden
                    $searches[] = "a.dateReceipt LIKE '%$search%' "; //Buscar por fehca de recepcion
                    $searches[] = "a.weeks LIKE '%$search%' "; //semanas                                       
                    
                    $searchQuery = implode(' OR ', $searches);
                    $searchQuery = ' WHERE ' .$searchQuery;
                }else{
                    $searchQuery = '';
                }
                
                    $query = "
                            SELECT a.*, b.name as name_user
                            FROM #__orderslp as a
                            LEFT JOIN #__users as b ON b.id=a.idCustomer
                            $searchQuery
                            ORDER BY a.idOrder
                          ";                                       
                    //echo $query;
                                
                $db->setQuery($query);
                $db->query();    
                $rows = $db->loadObjectList();                                                                  
                $this->items = $rows;
                
                $this->total = count($rows);
                if ($limitstart >= $this->total) {
                        $limitstart = $limitstart < $limit ? 0 : $limitstart - $limit;
                        $this->setState('list.start', $limitstart);
                }
                
                if ($ordering) {
                        if ($direction == 'asc') {
                                ksort($rows);                                    
                        }
                        else {
                                krsort($rows);
                        }
                }
                else {
                    if ($direction == 'asc') {
                            asort($rows);
                    }
                    else {
                            arsort($rows);
                    }
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
                
        public function deleteOrderById($idOrder){
             //Obtener el numero de orden para poder borrar los detalles                         
                $db = JFactory::getDbo();                                                                
                
                foreach($idOrder as $idO):
                    $queryOrderNum = "SELECT orderNum FROM #__orderslp WHERE idOrder=$idO ";                              
                    $db->setQuery($queryOrderNum);
                    $db->query();                    
                    $ordenNum = $db->loadResult();                          
                    
                    $queryDetails = "DELETE FROM #__productslp WHERE orderNum IN ('$ordenNum') ";                                      
                    $db->setQuery($queryDetails);
                    $db->query();

                    $query = "DELETE FROM #__orderslp WHERE idOrder=$idO ";                              
                    $db->setQuery($query);
                    $result[] = $db->query();                    
                    
                endforeach;                          
             
             return $result;
        }          
}

?>
