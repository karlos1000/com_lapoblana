//Validar campos utilizando libreria jquery
Joomla.submitbutton = function(task)
{            
        var action = task.split('.');
        if(action[1] != 'cancel' && action[1] != 'close')
        {                                                     
            
            var isValid = JQ("#adminForm").valid();
            if(isValid){                                                
                //Joomla.submitform(task, document.getElementById('adminForm'));                     
                Joomla.submitform(task);
                showProgress();                
                return true;
            }
            else
            {
                return false;
            }    
        }else{
            Joomla.submitform(task);
            return true;
        }                   
}

//muestra el loading de carga
JQ(document).ready(function(){    
    JQ('#progressBar').hide();
});

function showProgress() {
    JQ('#boxMassiveRecord').hide();    
    var pathImg = JQ('#loading_img').val();
    JQ('#progressBar').show();   
}
