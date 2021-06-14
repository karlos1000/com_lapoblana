<?php
// No direct access.
defined('_JEXEC') or die;
jimport('joomla.application.component.modellist');

class LapoblanaModelListcustomers extends JModelList
{
	/**
	 * Constructor.
	 *
	 * @param	array	An optional associative array of configuration settings.
	 * @see		JController
	 * @since	1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(                                
                                'id',
				'name',
				'username'                                
			);
		}
		parent::__construct($config);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		// Load the filter state.
		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);
                               	                 
		// Load the parameters.                
		$params = JComponentHelper::getParams('com_lapoblana');
		$this->setState('params', $params);

		// List state information.
		parent::populateState('name', 'asc');
	}

	/**
	 * Method to get an array of data items.
	 *
	 * @return	mixed	An array of data items on success, false on failure.
	 * @since	1.6
	 */
	public function getItems()
	{
                                            
		if (!isset($this->items))
		{			
			$search				= $this->getState('filter.search');		                        
			$ordering			= $this->getState('list.ordering');
			$direction			= $this->getState('list.direction');
			$limitstart			= $this->getState('list.start');
			$limit				= $this->getState('list.limit');                                                                
                                                                      
                        $db = JFactory::getDbo();
                        $query = $db->getQuery(true);
                        $query->select('a.*,b.id as idUser,b.name, b.username');
                        $query->from('#__cat_customerslp AS a');
                        $query->join('LEFT', '#__users AS b ON b.id=a.userIdJoomla');                            
                        $query->where(' active=1 ');
                        if($search){                                
                            $query->where(' ( b.name LIKE '.$this->_db->Quote('%'.$this->_db->escape($search, true).'%') .
                                          ' OR b.username LIKE '.$this->_db->Quote('%'.$this->_db->escape($search, true).'%') .                                              
                                          ')'
                                    );                                                      
                        }
                        
                        $query->order('a.customerId ASC');
                        $db->setQuery($query);
                        //echo $query;
                        $result = $db->loadObjectList();

                        $this->items = $result;
                                                     
                            
			$this->total = count($result);
			if ($limitstart >= $this->total) {
				$limitstart = $limitstart < $limit ? 0 : $limitstart - $limit;
				$this->setState('list.start', $limitstart);
			}
			if ($ordering) {
				if ($direction == 'asc') {
					ksort($result);                                    
				}
				else {
					krsort($result);
				}
			}
			else {
				if ($direction == 'asc') {
					asort($result);
				}
				else {
					arsort($result);
				}
			}                        
			$this->items = array_slice($result, $limitstart, $limit ? $limit : null);
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
}
