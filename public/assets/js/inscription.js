/****** Animation type formulaire *******************************/
$("#statusSelector").on('change', function(e) {
    switch (e.target.value) {
        case 'Retraite':
            loadForm('/register/Retraite');
            break;
    
        case 'Etudiant':
            loadForm('/register/Etudiant');
            break;
    
        case 'Entrepreneur':
            loadForm('/register/Entrepreneur');
            break;
    
        case 'ProfessionLiberale':
            loadForm('/register/ProfessionLiberale');
            break;
    
        case 'Salarie':
            loadForm('/register/Salarie');
            break;
    
        default:
            loadForm('/register/SansEmploi');
            break;
    }
});

function loadForm(formUrl) {
    $('.loadingScreen').addClass('show');
    $.ajax({
        url  : formUrl,
        type : 'POST',
        async: true,
        success: function(data) {
            $("#form").empty();
            $("#form").append(data);
            $('.loadingScreen').removeClass('show');
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
            $('.loadingScreen').removeClass('show');
        }
    });
    return false;
}

$('.alert-danger').fadeOut(6500);