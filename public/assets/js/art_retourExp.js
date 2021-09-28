//******* Like */
$("#thumbs").click( (e) => {
    //* cfg
    let url       = "";
    let color     = "";
    let increment = null;
    //* getter data
    let id        = $(e.target).data("id");
    let isLiked   = $(e.target).data("liked");

    if (isLiked == true) {
        //* Unlike 
        url       = "unlike/" + id;
        color     = "#383d41";
        increment = false;
        //* Update thumbs data liked
        $(e.target).data("liked", false);
    } else {
        //* Like
        url       = "like/" + id;
        color     = "#4169E1";
        increment = true;
        //* Update thumbs data liked
        $(e.target).data("liked", true);
    }

    $.ajax({
        type : "post",
        url  : url,
        success: function (response) {
            $(e.target).css("color", color);
            updateLike(increment);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert('Error : ' + errorThrown);
        }
    });
});

function updateLike(increment) {
    if (increment === true) {
        $("#js-likes").text(parseInt($("#js-likes").text()) + 1);
    } else {
        $("#js-likes").text(parseInt($("#js-likes").text()) - 1);
    }
}

//******* Modifier un commentaire */
function modifyComment (e , id) {
    let commentaire = $($(e.target).parents(".comments").children("div.col-9")).children("#commContent");
    let value       = $.trim(commentaire.text()); 

    commentaire.replaceWith("<input id='modif' type='text' class='form-control w-100'  value='" + value + "' autofocus>");

    $("#modif").keydown( (e) => {
        if ((e.key || e.code) == "Enter" || e.wich == 13) {
           $(e.target).focusout();
        }
    });

    $("#modif").focusout( (e) => {
        let modifiedComm = $.trim($(e.target).val());
        let dataComm     = {request : $.trim($(e.target).val())};

        $(e.target).replaceWith("<p id='commContent' class='font-italic mx-5'>" + modifiedComm +" </p>");

        $.ajax({
            type    : "post",
            url     : "modifComm/" + id ,
            data    : dataComm,
            success: function (response) {
                console.log("Comment successfully modified");
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert('Error : ' + errorThrown);
            }
        });
    });
}

//******* Commentaire voir plus */
if ($(".commentsToggled").length >= 3) {
    $(".commentsToggled").slice(0, 3).removeClass("commentsToggled");
    $('.commentsToggled').toggle();
} else {
    $("#showMoreComments").hide();
}

$("#showMoreComments").click( (e) => {
    e.preventDefault();
    e.stopPropagation();

    if ($(e.target).text() == 'Voir moins ') {
        $(e.target).text('Voir plus ').append($("<i>").addClass("bi bi-arrow-bar-down"));
    } else {
        $(e.target).text('Voir moins ').append($("<i>").addClass("bi bi-arrow-bar-up"));
    }
    $('.commentsToggled').toggle();
});

if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
    $("#commentaires_contenu").val("");
}


//******* Supprimer un commentaire */
    // $("#btnDelete").onClick( (e) => {

    //     $("#commentaire").empty();
    //     $.ajax({
    //         type    : "post",
    //         url     : "deleteComm/" + id ,
    //         data    : dataComm,
    //         success: function (response) {
    //             $("#commentaire").empty();
    //             console.log("Comment successfully delete");
    //         },
    //         error: function(XMLHttpRequest, textStatus, errorThrown) {
    //             alert('Error : ' + errorThrown);
    //         }
    //     });
    // });


//******* Supprimer un commentaire */
    // function supprimComment(id) {  
    //     // $("#commentaire").empty();
    //     let token = $("#btnDelete").data("token");
    //     $.ajax({
    //         type    : "post",
    //         url     : "deleteComm/" + id ,
    //         data    : token,
    //         success: function (response) {
    //             $("#commentaire").empty();
    //             console.log("Comment successfully delete"); 
    //         },
    //         error: function(XMLHttpRequest, textStatus, errorThrown) {
    //             alert('Error : ' + errorThrown);
    //         }
    //     });
    // }
