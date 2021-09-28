var currentClass = '';
window.onload = () => {
    document.getElementById("desc").classList.add('hide');
    document.getElementById("tit_desc").classList.remove('hide');
}

$(document).ready(function (){
    //let arr = [];
    const arr = [...($('#some-link').data()['id'])];
   
    let texteLien = '';
    let textBn= '';
    const bnTxt = $('.btnRed'); 
    const bnModif = $('.btnPole');
    for(b of bnTxt){
        texteLien = b.innerHTML;
        if(!arr.includes(parseInt(b.getAttribute('id'),10))){
            texteLien = 'S\'abonner à la newsletter' + texteLien;
        }else{
            texteLien = 'Se désinscrire de la newsletter' + texteLien; 
            b.classList.remove('btnRed');
            b.classList.add('red');
        }
        b.innerHTML = texteLien;

    }
    let texte = '';

    for(i=0; i<bnModif.length;i++){
        console.log(bnModif[i]);
      
    }


    for(let btnPole of bnModif){
        texte = btnPole.innerHTML;
        if(!arr.includes((parseInt(btnPole.getAttribute('id'),10))/10)){
            textBn = 'Je m\'abonne...';
            
        }else{
            textBn = 'Je me désinscris'; 
        }
        btnPole.innerHTML = textBn;
    }

});



function openMenu(menuName) {
    var i, x;
    x = document.getElementsByClassName("menuTab");

    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }
    document.getElementById(menuName).style.display = "block";
    document.getElementById("desc").classList.remove('hide');
    document.getElementById("tit_desc").classList.add('hide');
}

document.querySelectorAll('a.detailsPole').forEach(function (link) {
    link.addEventListener('mouseover', mouseOver);
})


function mouseOver(e) {
    var cube = document.querySelector('.nomPole');

    if (currentClass){
    cube.classList.remove(currentClass);
    }
    var showClass = 'show-' + e.target.id
    cube.classList.add(showClass);
    currentClass = showClass;
    //** Changement de couleur des titres */
    if(e.target.id == '10'){
        $("#titreLeft").css("color","var(--couleurOrange)")
    }else{
        
        $("#titreLeft").css("color","var(--couleurGris)")
    }

    if(e.target.id == '60'){
        $("#titreFront").css("color","var(--couleurJaune)")
    }else{
        $("#titreFront").css("color","var(--couleurGris)")
    }

    if(e.target.id == '20'){
         $("#titreRight").css("color","var(--couleurRougePole)")
    }else{
        $("#titreRight").css("color","var(--couleurGris)")
    }

    if(e.target.id == '40'){
        $("#titreBottom").css("color","var(--couleurVert)")
    }else{
        $("#titreBottom").css("color","var(--couleurGris)")
    }

    if(e.target.id == '50'){
        $("#titreTop").css("color","var(--couleurViolet)")
        }else{
        $("#titreTop").css("color","var(--couleurGris)")
    }

    if(e.target.id == '30'){
         $("#titreBack").css("color","var(--couleurBleuPole)")
    }else{
        $("#titreBack").css("color","var(--couleurGris)")
    }
}