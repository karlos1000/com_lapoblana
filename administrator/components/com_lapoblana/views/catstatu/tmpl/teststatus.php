<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// load tooltip behavior
JHtml::_('behavior.tooltip');
$model = JModelLegacy::getInstance('Globalmethods', 'LapoblanaModel');                     
$collStatus = $model->GetAllStatus();    
$collDrawings = $model->GetAllDrawings();    
$collProducts = $model->GetAllProducs();    

echo '<pre>';
    print_r($collProducts);
echo '</pre>';

foreach($collProducts as $item){
    echo $item->productName .'<br/>';
}

?>

