<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('joomla.application.component.controllerform');

class LapoblanaControllerUpload extends JControllerForm {
    
    function cancel()
    {    
     $this->setRedirect( 'index.php?option=com_lapoblana');
    }    
    
    
    function uploadImg(){                        
        //$max = ini_get('upload_max_filesize');
        $max = '1000000';
        $module_dir = JPATH_SITE.'/media/com_lapoblana/upload_files_img';   //JURI::root().'media/com_lapoblana/upload_files_xls';                
                        
        //Retrieve file details from uploaded file, sent from upload form
        $fileArr = JRequest::getVar('file_upload', null, 'files', 'array'); 
         
       $arrResult = $this->reArrayFiles($fileArr);
//        echo '<pre>';
//            print_r($arrResult);
//        echo '</pre>';
       
       foreach($arrResult as $file){           
           
           if($file['name']!=''){                                               
               $src = $file['tmp_name'];
               $dest = $module_dir . DS . $file['name'];                                
               $ext = end(explode(".", $file['name']));

                //First check if the file has the right extension, we need jpg only
                if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg' || $ext == 'gif') {
                    if($file['size'] > $max){
                        $maxSize[] = $file['name'];                        
                    }else{
                        if ( JFile::upload($src, $dest) ) {                        
                            $save[] = $file['name'];
                        }else {                          
                             $error[] = $file['name'];                        
                        }
                    }                     
                } else {                  
                        $invalidType[] = $file['name'];                       
                }
                
                if(count($save)>0){                    
                    $html = '<div style="font-weight:normal;text-indent:0px;margin-left:40px;">';
                    $html .= '<table width="300" style="border:1px solid #888;text-align:center;background:#fff;color:#000;border-radius:10px;">
                                <tr>
                                    <td colspan="1"><div style="font-weight:bold;padding:5px;height:20px;">Imagen/es salvadas correctamente</div></td>
                                </tr>
                                <tr style="text-align:center;">
                                    <td>NOMBRE IMAGEN</td>                                    
                                </tr>';
                     foreach($save as $item){                                
                         $html .= '<tr><td>'.$item.'</td></tr>';
                     }                                             
                     $html .= '</table></div><br/>'; 
                   $success = $html;
                }else{
                   $success = '';
                }
                
                if(count($error)>0){                                       
                   $html = '<div style="font-weight:normal;text-indent:0px;margin-left:40px;">';
                    $html .= '<table width="300" style="border:1px solid #888;text-align:center;background:#fff;color:#000;border-radius:10px;">
                                <tr>
                                    <td colspan="1"><div style="font-weight:bold;padding:5px;height:20px;">Imagen/es que no se pudiron subir</div></td>
                                </tr>
                                <tr style="text-align:center;">
                                    <td>NOMBRE IMAGEN</td>                                    
                                </tr>';
                     foreach($error as $item){                                
                         $html .= '<tr><td>'.$item.'</td></tr>';
                     }                                             
                     $html .= '</table></div><br/>'; 
                     $errors = $html;
                }else{
                    $errors = '';
                }
                
                if(count($maxSize)>0){
                    $html = '<div style="font-weight:normal;text-indent:0px;margin-left:40px;">';
                    $html .= '<table width="300" style="border:1px solid #888;text-align:center;background:#fff;color:#000;border-radius:10px;">
                                <tr>
                                    <td colspan="1"><div style="font-weight:bold;padding:5px;height:20px;">Imagen/es que no se subieron porque exceden mas de 1mb</div></td>
                                </tr>
                                <tr style="text-align:center;">
                                    <td>NOMBRE IMAGEN</td>                                    
                                </tr>';
                     foreach($maxSize as $item){                                
                         $html .= '<tr><td>'.$item.'</td></tr>';
                     }                                             
                     $html .= '</table></div><br/>'; 
                     $maxsize = $html;
                }else{
                    $maxsize = '';
                }
                
                if(count($invalidType)>0){
                    $html = '<div style="font-weight:normal;text-indent:0px;margin-left:40px;">';
                    $html .= '<table width="300" style="border:1px solid #888;text-align:center;background:#fff;color:#000;border-radius:10px;">
                                <tr>
                                    <td colspan="1"><div style="font-weight:bold;padding:5px;height:20px;">Imagen/es que no cumplen con los tipos de extensión se permiten (png, jpg o gif)</div></td>
                                </tr>
                                <tr style="text-align:center;">
                                    <td>NOMBRE IMAGEN</td>                                    
                                </tr>';
                     foreach($invalidType as $item){                                
                         $html .= '<tr><td>'.$item.'</td></tr>';
                     }                                             
                     $html .= '</table></div><br/>'; 
                     $maxsize = $html;
                }else{
                    $maxsize = '';
                }
                
                
                
                $htmlMsg = $success.$maxsize.$errors;
                $this->setRedirect( 'index.php?option=com_lapoblana&view=upload',$htmlMsg);           
           }
       } 
                     
    }
    
     function reArrayFiles(&$file_post) {

        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);

        for ($i=0; $i<$file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }

        return $file_ary;
    } 
      
    
}

?>
