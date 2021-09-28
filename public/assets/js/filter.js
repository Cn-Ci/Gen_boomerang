$('#searchBar').on('input', (e) => {
    /* 
        //* filter without back-end connection

        $("#dataOrderBy div .card").filter( function() {
            $(this).parent().toggle(
                $(this).text().toLowerCase().indexOf(value) > -1
            );
        }); 
    */

    let keyword = $("#searchBar").val().toLowerCase();

    try {
        $("#dataOrderBy").load("searchBar/" + keyword + " #dataOrderBy");
    } catch (error) {
        alert("Une erreur est survenue lors du chargement de la page <br> " + error);
    }
});

$("#selectOrderBy").change( (e) =>  { 
    const option = $("#selectOrderBy :selected").attr("name");

    try {
        $("#dataOrderBy").load("orderBy/" + option + " #dataOrderBy");
    } catch (error) {
        alert("Une erreur est survenue lors du chargement de la page <br> " + error);
    }
});