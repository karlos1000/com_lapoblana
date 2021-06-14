<?php
/** 
 * fecha: 19-11-13
 * company: company
 * @author Karlos
 */
// No direct access to this file
defined('_JEXEC') or die;
// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');
 
/**
 * Clase de campo de formulario para el componente Lapoblana
 */

class JFormFieldLapoblana extends JFormFieldList{
     /**
         * The field type.
         *
         * @var         string
         */
        protected $type = 'Lapoblana';
 
        /**
         * Method to get a list of options for a list input.
         *
         * @return      array           An array of JHtml options.
         */
        protected function getOptions() 
        {
                $db = JFactory::getDBO();
                $query = $db->getQuery(true);
                $query->select('id,greeting');
                $query->from('#__lapoblana');
                $db->setQuery((string)$query);
                $messages = $db->loadObjectList();
                $options = array();
                if ($messages)
                {
                        foreach($messages as $message) 
                        {
                                $options[] = JHtml::_('select.option', $message->id, $message->greeting);
                        }
                }
                $options = array_merge(parent::getOptions(), $options);
                return $options;
        }
}

?>
