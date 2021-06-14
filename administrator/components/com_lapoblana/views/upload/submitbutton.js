
JQ(document).ready(function(){               
    JQ("#newInputFile").click(function (){                
        input = '<li><input type="file" name="file_upload[]" size="10" multiple="multiple" /></li>';
        JQ("#inputsFiles").append(input);
    });
    
    JQ("#btnUpload").click(function(){
        Joomla.submitbutton('upload.uploadImg');            
    });
});


Joomla.submitbutton = function(task)
{
    if (task == '')
    {
        return false;
    }
    else
    {
        var isValid = true;
        var action = task.split('.');
        if (action[1] != 'cancel' && action[1] != 'close')
        {
            var forms = $$('form.form-validate');
            for (var i = 0; i < forms.length; i++)
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