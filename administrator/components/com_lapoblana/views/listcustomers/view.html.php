<?php

defined('_JEXEC') or die;

class LapoblanaViewListcustomers extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{                              
            $this->items = $this->get('Items');
            $this->pagination = $this->get('Pagination');
            $this->state = $this->get('State');

            // Check for errors.
            if (count($errors = $this->get('Errors'))) {
                    JError::raiseError(500, implode("\n", $errors));
                    return false;
            }                                                

            parent::display($tpl);
	}
}
