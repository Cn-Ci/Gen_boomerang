$('#searchBarMembre').on('input', (e) => {
    let keyword = $("#searchBarMembre").val().toLowerCase();
    console.log(keyword)
    try {
        $("#membre").empty();
        $("#membre").load("searchBar/" + keyword + " #membreSearched");
    } catch (error) {
        alert("Une erreur est survenue lors du chargement de la page <br> " + error);
    }
});

$("#selectOrderByType").change( (e) =>  { 
    const option = $("#selectOrderByType :selected").attr("name");
    console.log(option)
    try {
        $("#membre").load("orderByType/" + option + " #membreSearched");
    } catch (error) {
        alert("Une erreur est survenue lors du chargement de la page <br> " + error);
    }
});

$("#selectOrderBy").change( (e) =>  { 
    const option = $("#selectOrderBy :selected").attr("name");
    console.log(option)
    try {
        $("#membre").load("orderBy/" + option + " #membreSearched");
    } catch (error) {
        alert("Une erreur est survenue lors du chargement de la page <br> " + error);
    }
});