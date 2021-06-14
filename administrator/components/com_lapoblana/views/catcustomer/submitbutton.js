JQ(document).ready(function(){                                             
    JQ('input[name=\"active\"]').click(function() {
        var v = JQ(this).val();
        var value = (v == 1) ? '0' : '1';
        JQ('#active').val(value);
    });
});

function jSelectCustomer(nameCustomer, user, idUserJoomla) {
     //console.log(nameCustomer +' - ' + user + ' - ' +idUserJoomla);
     JQ("#customerName").val(nameCustomer);
     JQ("#userName").val(user);
     JQ("#idUser_hidden").val(idUserJoomla);     
     SqueezeBox.close();
}

//Joomla.submitbutton = function(task)
//{    
//        
//        var action = task.split('.');
//        if(action[1] != 'cancel' && action[1] != 'close')
//        {
//            var isValid = JQ("#adminForm").valid();
//            if(isValid){                
//                //Joomla.submitform(task, document.getElementById('adminForm'));                     
//                Joomla.submitform(task);
//                return true;
//            }
//            else
//            {
//                return false;
//            }    
//        }else{
//            Joomla.submitform(task);
//            return true;
//        }                   
//}

Joomla.submitbutton = function(task)
{
        if (task == '')
        {
                return false;
        }
        else
        {
                var isValid=true;
                var action = task.split('.');
                if (action[1] != 'cancel' && action[1] != 'close')
                {
                        var forms = $$('form.form-validate');
                        for (var i=0;i<forms.length;i++)
                        {
                                if (!document.formvalidator.isValid(forms[i]))
                                {
                                        isValid = false;
                                        break;
                                }
                        }
                }
 
                if (isValid)
                {
                        Joomla.submitform(task);
                        return true;
                }
                else
                {                       
                        return false;
                }
        }
}
