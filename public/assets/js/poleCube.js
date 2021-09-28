 /* ANIMATION DU CUBE*/
 document.querySelectorAll('a.detailsPole').forEach(function (link) {
    link.addEventListener('mouseover', mouseOver);
})

var currentClass = '';

function mouseOver(e) {
    var cube = document.querySelector('.cube');

    if (currentClass){
    cube.classList.remove(currentClass);
    }

    var showClass = 'show-' + e.target.id
    cube.classList.add(showClass);
    currentClass = showClass;

    //** Changement de couleur des titres */
    if(e.target.id == 'left'){
        $("#titreLeft").css("color","var(--couleurOrange)")
    }else{
        
        $("#titreLeft").css("color","var(--couleurGris)")
    }

    if(e.target.id == 'front'){
        $("#titreFront").css("color","var(--couleurJaune)")
    }else{
        $("#titreFront").css("color","var(--couleurGris)")
    }

    if(e.target.id == 'right'){
         $("#titreRight").css("color","var(--couleurRougePole)")
    }else{
        $("#titreRight").css("color","var(--couleurGris)")
    }

    if(e.target.id == 'bottom'){
        $("#titreBottom").css("color","var(--couleurVert)")
    }else{
        $("#titreBottom").css("color","var(--couleurGris)")
    }

    if(e.target.id == 'top'){
        $("#titreTop").css("color","var(--couleurViolet)")
        }else{
        $("#titreTop").css("color","var(--couleurGris)")
    }

    if(e.target.id == 'back'){
         $("#titreBack").css("color","var(--couleurBleuPole)")
    }else{
        $("#titreBack").css("color","var(--couleurGris)")
    }
}