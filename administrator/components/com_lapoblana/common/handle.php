<?php
// no direct access
defined('_JEXEC') or die('Restricted access'); 
jimport('joomla.filesystem.file'); 

//echo dirname(__FILE__).DS;
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    // always modified
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    // HTTP/1.1
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    // HTTP/1.0
    header("Pragma: no-cache");	
    
    //require 'http://127.0.0.1:8888/toraguimarrprueba/administrator/components/com_lapoblana/common/KoolControls/KoolUploader/kooluploader.php';
    
    include_once JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_lapoblana' . DS . 'common' . DS . 'KoolControls' . DS . 'KoolAjax' . DS . 'koolajax.php';                                
    include_once JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_lapoblana' . DS . 'common' . DS . 'KoolControls' . DS . 'KoolUploader' . DS . 'kooluploader.php';        
    //$targetFolder = JURI::root().'media/com_lapoblana/upload_files_xls/';
    //$targetFolder = JURI::base().'/components/com_lapoblana/common';
    //Create handle object and edit upload settings.
    $kulhandle = new KoolUploadHandler();
    //$kulhandle->targetFolder = $targetFolder;
    $kulhandle->allowedExtension = "gif,jpg,png";
    //Call the handle function to handle the request from client
    //echo $kulhandle->handleUpload();
    
    function custom_upload_handle(&$file)
	{
         $targetFolder = JPATH_SITE.'/media/com_lapoblana/upload_files_xls';
		//Process saving file with $file information
		//$file["name"] : Name of file
		//$file["tmp_name"] : Temporary name(path)
		//$file["size"] : Size of file
		//$file["type"] : Type of file
		//$file["error"] : Error if any		
		if (move_uploaded_file($file["tmp_name"], $targetFolder.$file["name"]))
		{
			// success, return true
			return true;
		}
		else
		{
			//Fail to save file, return false
			return false;
		}     
	} 
	$kulhandle->funcFileHandle = custom_upload_handle;
 
	//Call the handle function to handle the request from client	
	echo $kulhandle->handleUpload();
    
?>