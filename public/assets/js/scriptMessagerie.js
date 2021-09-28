let lastId                = 0;
let userIdEnCours         = 0;
let superConversationId   = 0;
let defaultHeightWritemsg = parseInt($('.write_msg').css('height'));
var Interval;

function removeAllChildNodes(parent) {
    while (parent.firstChild) {
        parent.removeChild(parent.firstChild);
    }
}

$(".write_msg").on("keydown", (e) => {
    //* increment height of textarea 
    let map = {}; // You could also use an array
    let scrollHeight  = parseInt($(e.target).scrollTop());
    let currentHeight = parseInt($(e.target).css('height'));
    let totalHeight   = currentHeight + scrollHeight;
    map[e.key] = e.type == 'keydown';
 //   console.log(e.type);
    /* insert conditional here */

    if(map[enterKey]){
        ajoutMessage();
    }
    if(map[13] && !map[17]){
        $(e.target).css('height', totalHeight + 'px');
    }
});
    
    

function getMessages(conversationId , userId) {
    superConversationId = conversationId;
    userIdEnCours       = userId;

    //* On vide ce qu'il y avait avant
    removeAllChildNodes(document.querySelector('.msg_history'));

    //* On remet toutes les conversations en blanc
    let allDivs = document.getElementsByClassName('chat_list');
    for (let div of allDivs) {
        div.style.background = '#f8f8f8';
    }

    //* background-color light-grey quand conversation selectionné
    $("#"+ conversationId).css('background', "#e1e1e1")

    let xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            let messages   = JSON.parse(this.response);
            let discussion = document.querySelector('.msg_history');

            for (let message of messages) {
                let dateMessage = new Date(message.createdAt)
                var lastMessageId = message.id;

                //* Affichage selon envoyé ou reçu
                if (message.authorId == userIdEnCours) {
                    discussion.innerHTML += "<div class=\"outgoing_msg col-12 \"\><div class=\"sent_msg col-6 m-0\">"
                        + "<p class='m-0'>" + message.content + "</p>"
                        + "<span class=\"time_date\"> De " + message.author + " | " + dateMessage.toLocaleString() + "</span>"
                        + "</div>"
                    ;
                } else {
                    discussion.innerHTML += "<div class=\"incoming_msg col-12 \">"
                        + "<div class=\"received_msg col-12\"\><div class=\"received_withd_msg col-6\">"
                        + "<p>" + message.content + "</p>"
                        + "<span class=\"time_date_receiver\"> De " + message.author + " | " + dateMessage.toLocaleString() + "</span>"
                        + "</div></div>"
                    ;
                }
            }

            //* scroll dernier message
            let divMessagerie       = document.querySelector(".msg_history");
            divMessagerie.scrollTop = divMessagerie.scrollHeight;

            Interval = setInterval( () => {
                $.ajax({
                    type: "POST",
                    url : "/checkMessage/" + lastMessageId,
                    success: function (response) {
                        if (response === true) {
                            clearInterval(Interval);
                            getMessages(
                                superConversationId, 
                                userIdEnCours
                            );
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        alert(errorThrown);
                    }
                });
            }, 5000);
        }
    };

    //! Ouverture de la requete (MOCK VERS PROD)
    //* PROD 
    // xmlhttp.open("GET", "http://www.generation-boomerang.com/messagerie/conv/" + conversationId);
    //* DEV
    xmlhttp.open("GET", "/messagerie/conv/" + conversationId);

    xmlhttp.send();
}

function ajoutMessage() {
    //* On récup le messag

    let message = document.querySelector('.write_msg').value;
    if (message != "") {
        let donnees               = {};
        donnees["message"]        = message;
        donnees["conversationId"] = superConversationId;
        let donneesJson           = JSON.stringify(donnees);
        //* On envoie en POST AJAX
        let xmlhttp = new XMLHttpRequest();
        //* On gère la réponse
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.querySelector('.write_msg').value = "";
                $('.write_msg').css('height' , defaultHeightWritemsg + 'px');
                clearInterval(Interval);
                getMessages(superConversationId , userIdEnCours);
            }
        }

        //! Ouverture de la requete (MOCK VERS PROD)
        //* PROD 
        // xmlhttp.open("POST", "http://www.generation-boomerang.com/messagerie/newMessage");
        //* DEV
        xmlhttp.open("POST", "/messagerie/newMessage");

        xmlhttp.send(donneesJson);
    }
}

function deleteConversation(conversationId) {
    //* Controle ID conversation
    if (conversationId == null || conversationId == 0) {
        alert("Conversation non valide");
    } else {
        if (confirm('Vous êtes sur le point de supprimer la conversation, continuer ?')) {
            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    console.log('ajax envoyée !');
                }
            }

            //! Ouverture de la requete (MOCK VERS PROD)
            //* PROD
            // xmlhttp.open("GET", "http://www.generation-boomerang.com/messagerie/delete/" + conversationId);
            //* DEV
            xmlhttp.open("GET", "/messagerie/delete/" + conversationId);

            xmlhttp.send();

            //! Ouverture de la requete (MOCK VERS PROD)
            //* PROD 
            // document.location.href="http://www.generation-boomerang.com/messagerie/all"; 
            //* DEV
            document.location.href="/messagerie/all"; 
        }
    }
}

//* filter messagerie (par participants)
$('#filter').on("input", () => {
    let keyword = $('#filter').val().toLowerCase();

    $("#filter").filter( () => {
        $(".chat_list").toggle(
            $(".participant").text().toLowerCase().indexOf(keyword) > -1
        );
    });
});

//* Clear interval 
$(".chat_list").click( (e) =>  {
    clearInterval(Interval);
})