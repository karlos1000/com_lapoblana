<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access'); 
// load tooltip behavior
$modelGM = JModelLegacy::getInstance('Globalmethods', 'LapoblanaModel');                   
$idClient = $modelGM->chekExistClient('pedro');


if($idClient==0){
    $idClient = null;
}
//se ha insertado el cliente pero no tiene un usuario joomla aosiado
if($idClient == -1){
    $idClient = null;
}

if($idClient != -1 && $idClient != 0){
    $idClient = $idClient;
}

echo 'El resultado es: ' .$idClient;



?>