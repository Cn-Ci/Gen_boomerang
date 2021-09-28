$(document).ready(function() 
{
            
    $("form#mdp_form").submit(function(e) 
    {
        if($("#inputPassword1").val() == $("#inputPassword2").val())
        {
            
            $('#mdp_message').html("");
        }
        else
        {
            e.preventDefault();
            $('#mdp_message').html("Les mots de passe ne correspondent pas");
        }
    });

    
});