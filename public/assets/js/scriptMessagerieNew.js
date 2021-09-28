let conversationNew = {};
let tabParticipants = [];
let tabUserNames    = [];

window.onload = () => {
    //* conversationNew = {};
    //* tabParticipants = [];
}

function ajoutParticipant(userId) {
    let userSelected = document.getElementById(userId);
    let btnAjout     = document.getElementById('btn'+userId);
    let userName     = document.getElementById('btn'+userId).value;

    //* Affichage de la liste des participants
    let ligneParticipants = document.getElementById('ligneParticipants');

    //* Check si participant pas déjà ajouté
    if (!tabParticipants.includes(userId)) {
        //* Changer la couleur de la case bleu = selectionné
        userSelected.style.background = '#f5f5f5';

        //* Changement couleur et contenu du bouton
        btnAjout.style.background = 'red';
        btnAjout.innerHTML        = '<i class = "fas fa-user-minus"></i>';

        tabParticipants.push(userId);
        tabUserNames.push(userName);
        conversationNew["participants"] = tabParticipants;
        
        //* Affichage du nom du participant ajouté
        ligneParticipants.innerHTML = tabUserNames;

        let participantsJson = JSON.stringify(conversationNew);

    } else {
        userSelected.style.background = '#f8f8f8';
        btnAjout.style.background     = 'green';
        btnAjout.innerHTML            = '<i class = "fas fa-user-plus"></i>';

        //* Récup index du user à supprimer + sup du tableau
        tabParticipants.splice(tabParticipants.indexOf(userId) , 1);

        //* test avec les noms
        tabUserNames.splice(tabUserNames.indexOf(userName) , 1);

        //* mise à jour de la liste des participants
        ligneParticipants.innerHTML = tabUserNames ;

        let participantsJson = JSON.stringify(conversationNew);
    }
}

function ajoutMessage() {
    //* Check if list of user is not null
    if (tabParticipants.length == 0) {
        alert('Ajoute au moins qqun avec qui discuter !');
    } else {
        //* cfg global
        let groupName                = $('#groupName').val();
        //* cfg ajax
        let donnees                  = {};
        donnees["message"]           = "Bienvenue dans ce groupe !";
        donnees["groupName"]         = groupName;
        donnees["listeParticipants"] = tabParticipants;
        let donneesJson              = JSON.stringify(donnees);
        $.ajax({
            type       : "POST",
            url        : "/messagerie/createConv",
            data       : donneesJson,
            contentType: "application/json",
            dataType   : "json",
            success: function (response) {
                $('#groupName').val('');

                //! Ouverture de la requete (MOCK VERS PROD)
                //* PROD 
                // window.location.href = 'https://www.generation-boomerang.com/messagerie/all';
                //* DEV
                window.location.href = '/messagerie/all';
            }, error: function (xhr, status, errorThrown) {
                console.log('Error : ' + errorThrown);
            }
        });
    }
}