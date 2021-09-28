/* Vérification des parametres d'accessibilité  */

window.onload = function () {
  $('.collapse').collapse('hide');  /* Fléches Pages FAQ */

  /* Vérification mode sombre */
  if (localStorage.getItem('sombre') == "true") 
  {
    $(".active3").removeClass("active3");
    $("body").toggleClass("active2");
    //! home page image
    $("#container-wave").toggleClass("active2");
    $(".nomPole").toggleClass("active2");
    $(".colorBlueGB").toggleClass("active2");
    $(".colorRedGB").toggleClass("active2");
    $("#desc").toggleClass("active2");

    //! mon compte 
    $(".menuCompte").toggleClass("bg-lightdarkmode");
    $(".lienMenuCompte").toggleClass("font-white");
    $("#account_unemployed_birthdate_day").toggleClass("bg-lightdarkmode");
    $("#account_unemployed_birthdate_day").toggleClass("bg-lightdarkmode");
    $("#account_unemployed_birthdate_day").toggleClass("bg-lightdarkmode");

    //! view article page
    $(".font-white").toggleClass("active2");
    $(".artStats").toggleClass("font-white");
    $(".commentaire").toggleClass("bg-lightdarkmode");
    $("#commentaires_rating").toggleClass("bg-darkmode");
    $(".inputBorder").toggleClass("active2");

    //! Actualite 
    //$("h3").toggleClass("active2");
    $("h4").toggleClass("active2");
    $("h2").toggleClass("active2");
    $(".lienUrl").toggleClass("active2");

    //! Accessibilite 
    $(".bg-black").toggleClass("active2");
  }

  /*  Vérification mode dyslexique  */

  if (localStorage.getItem('dyslexique') == "true") 
  {

    $("body").toggleClass("active");
  }

  /*  Vérification mode daltonien */

  if (localStorage.getItem('daltonien') == "true") 
  {

    $(".active2").removeClass("active2");
    $("body").removeClass("active2");

    //! Body en general
    $("body").toggleClass("active3");
    $("h1").toggleClass("active3");
    $("h2").toggleClass("active3");
    $("h3").toggleClass("active3");
    $("h4").toggleClass("active3");
    $(".btnRed").toggleClass("active3");
    $("a.btn.btnRed").toggleClass("active3");
    $("p").toggleClass("active3");

    //! navbar 1 et 2 
    $("#navDef1").toggleClass("active3");

    $(".dropdown-item").toggleClass("active3");
    $("dropdown-item:hover").toggleClass("active3");
    $(".navPrincipal").toggleClass("active3");
    $("#btnSearch").toggleClass("active3");
    $("i.fas").toggleClass("active3");
    $(".dropdown-menu").toggleClass("active3");
    $(".dropdown-toggle").toggleClass("active3");
    $("#navbarDropdownPole2").toggleClass("active3");
    $("#navbarDropdown").toggleClass("active3");
    $("#navbarDropdownDifferentPole").toggleClass("active3");
    $("#navbarDropdown2").toggleClass("active3");
    $("#navbarDropdown3").toggleClass("active3");


    //! Footer
    $("#bg").toggleClass("active3");
    $(".fab").toggleClass("active3");
    $(".lienFooter").toggleClass("active3");
    $("#textFoot").toggleClass("active3");

    //! navbarCube
    $(".lienMenu").toggleClass("active3");
    $(".menuCubePole").toggleClass("active3");
    $(".menuCubePole").toggleClass("active3");
    $(".btnPole").toggleClass("active3");
    $("span.carousel-control-prev-icon").toggleClass("active3");
    $("span.carousel-control-next-icon").toggleClass("active3");
    $(".semper").toggleClass("active3");
    $(".titreCard").toggleClass("active3");
    $(".btnContact").toggleClass("active3");

    //! Inscription / Connexion
    $(".hrInscription").toggleClass("active3");
    $("label").toggleClass("active3");
    $(".formBorder").toggleClass("active3");
    $("legend").toggleClass("active3");
    $(".textBleu").toggleClass("active3");
    $(".lienCharte").toggleClass("active3");
    $("#login").toggleClass("active3");
    $(".hrLogin").toggleClass("active3");
    $(".mdpForget").toggleClass("active3");
    $(".card").toggleClass("active3");
    $(".card-header").toggleClass("active3");

    //! Account Moncompte    
    $(".menuCompte").toggleClass("active3");
    $(".lienMenuCompte").toggleClass("active3");
    $(".hrAbonnement").toggleClass("active3");
    $("th").toggleClass("active3");
    $("#file-ip-1-preview").toggleClass("active3");
    $(".inputBorder").toggleClass("active3");
    $(".conditionsGeneral").toggleClass("active3");
    $(".hrVertical").toggleClass("active3");
    $(".titreMission").toggleClass("active3");
    $(".lienSlug").toggleClass("active3");
    $("i.far.fa-eye").toggleClass("active3");
    $(".vl").toggleClass("active3");
    $("p.h4.titreCard").toggleClass("active3");
    $(".hauteurText").toggleClass("active3");
    $(".hrMonCompte").toggleClass("active3");
    $(".recherche").toggleClass("active3");
    $(".selectBord").toggleClass("active3");
    $(".imgSize").toggleClass("active3");
    $(".hrNewsletter").toggleClass("active3");
    $(".box").toggleClass("active3");
    $(".hrBox").toggleClass("active3");
    $(".hrProfil").toggleClass("active3");
    $("a.menuHamb").toggleClass("active3");
    $(".dropdown-submenu").toggleClass("active3");
    $("a.dropdown-item").toggleClass("active3");
    $(".fondColore").toggleClass("active3");
    $("#boomerangHeader").toggleClass("active3");
    $(".colorCommRechercheEtDev").toggleClass("active3");
    $(".colorImmobilier").toggleClass("active3");
    $(".colorEvolutionDesMetiers").toggleClass("active3");
    $(".colorSavoirs").toggleClass("active3");
    $(".colorInclusiveDesign").toggleClass("active3");
    $(".hrArticle").toggleClass("active3");
    $(".menu").toggleClass("active3");
    $(".lienUrl").toggleClass("active3");
    $(".grid figcaption").toggleClass("active3");
    $(".grid figcaption a").toggleClass("active3");
    $(".menuHamb").toggleClass("active3");
    $(".lienNoir").toggleClass("active3");
    $(".lienBlanc").toggleClass("active3");
    $(".navbar-light .navbar-nav .nav-link").toggleClass("active3");
    $(".grid figcaption a").toggleClass("active3");
    //! HomePage 
    $(".colorBlueGB").toggleClass("active3");
    $(".colorRedGB").toggleClass("active3");
    //! RetourExp
    $(".page-link.active3").toggleClass("active3");
    $("a").toggleClass("active3");
    $(".hauteurText").toggleClass("active3");
    $("i.fas.fa-user").toggleClass("active3");
    $("i.fas.fa-thumbs-up").toggleClass("active3");
  }
  
};


function getStylePropertyValue(elemId, prop) 
{
  let elem = document.getElementById(elemId);
  return window.getComputedStyle(elem).getPropertyValue(prop);
}


/****** Recherche *******************************/
$("#recherche").hide();
function search() 
{
  let x = document.getElementById("recherche");
  if (x.style.display === "none") 
  {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

/****** dropdown Navbar2 *******************************/
$(function () {
  $("ul.dropdown-menu [data-toggle='dropdown']").on("click", function (event) {
    event.preventDefault();
    event.stopPropagation();

    //method 1: remove show from sibilings and their children under your first parent

    /* 		
      if (!$(this).next().hasClass('show')) {     
        $(this).parents('.dropdown-menu').first().find('.show').removeClass('show');
      }  
    */

    //method 2: remove show from all siblings of all your parents
    $(this).parents('.dropdown-submenu').siblings().find('.show').removeClass("show");
    $(this).siblings().toggleClass("show");

    //collapse all after nav is closed
    $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function (e) {
      $('.dropdown-submenu .show').removeClass("show");
    });
  });
});

/****** Dyslexique *******************************/
$(document).ready(function () {
  $(".btnDys").click(function () {
    $("body").toggleClass("active");
  });
});

/****** Mode Sombre *******************************/


$(document).ready(function () {
  $(".btnSombre").click(function () {

    $(".active3").removeClass("active3");
    $("body").toggleClass("active2");
    //! home page image
    $("#container-wave").toggleClass("active2");
    $(".nomPole").toggleClass("active2");
    $(".colorBlueGB").toggleClass("active2");
    $(".colorRedGB").toggleClass("active2");
    $("#desc").toggleClass("active2");
    //! mon compte 
    $(".menuCompte").toggleClass("bg-lightdarkmode");
    $(".lienMenuCompte").toggleClass("font-white");
    $("#account_unemployed_birthdate_day").toggleClass("bg-lightdarkmode");
    $("#account_unemployed_birthdate_day").toggleClass("bg-lightdarkmode");
    $("#account_unemployed_birthdate_day").toggleClass("bg-lightdarkmode");
    //! view article page
    $(".font-white").toggleClass("active2");
    $(".artStats").toggleClass("font-white");
    $(".commentaire").toggleClass("bg-lightdarkmode");
    $("#commentaires_rating").toggleClass("bg-darkmode");
    $(".inputBorder").toggleClass("active2");
    //! Actualite 
    //$("h3").toggleClass("active2");
    $("h4").toggleClass("active2");
    $("h2").toggleClass("active2");
    $(".lienUrl").toggleClass("active2");
    //! Accessibilite 
    $(".bg-black").toggleClass("active2");
    //! Partenaire

  });
});




/****** Mode Daltonien *******************************/
$(document).ready(function () {
  $(".btnDaltonien").click(function () {
    $(".active2").removeClass("active2");
    $("body").removeClass("active2");

    //! Body en general
    $("body").toggleClass("active3");
    $("h1").toggleClass("active3");
    $("h2").toggleClass("active3");
    $("h3").toggleClass("active3");
    $("h4").toggleClass("active3");
    $(".btnRed").toggleClass("active3");
    $("a.btn.btnRed").toggleClass("active3");
    $("p").toggleClass("active3");

    //! navbar 1 et 2 
    $("#navDef1").toggleClass("active3");

    $(".dropdown-item").toggleClass("active3");
    $("dropdown-item:hover").toggleClass("active3");
    $(".navPrincipal").toggleClass("active3");
    $("#btnSearch").toggleClass("active3");
    $("i.fas").toggleClass("active3");
    $(".dropdown-menu").toggleClass("active3");
    $(".dropdown-toggle").toggleClass("active3");
    $("#navbarDropdownPole2").toggleClass("active3");
    $("#navbarDropdown").toggleClass("active3");
    $("#navbarDropdownDifferentPole").toggleClass("active3");
    $("#navbarDropdown2").toggleClass("active3");
    $("#navbarDropdown3").toggleClass("active3");


    //! Footer
    $("#bg").toggleClass("active3");
    $(".fab").toggleClass("active3");
    $(".lienFooter").toggleClass("active3");
    $("#textFoot").toggleClass("active3");

    //! navbarCube
    $(".lienMenu").toggleClass("active3");
    $(".menuCubePole").toggleClass("active3");
    $(".menuCubePole").toggleClass("active3");
    $(".btnPole").toggleClass("active3");
    $("span.carousel-control-prev-icon").toggleClass("active3");
    $("span.carousel-control-next-icon").toggleClass("active3");
    $(".semper").toggleClass("active3");
    $(".titreCard").toggleClass("active3");
    $(".btnContact").toggleClass("active3");

    //! Inscription / Connexion
    $(".hrInscription").toggleClass("active3");
    $("label").toggleClass("active3");
    $(".formBorder").toggleClass("active3");
    $("legend").toggleClass("active3");
    $(".textBleu").toggleClass("active3");
    $(".lienCharte").toggleClass("active3");
    $("#login").toggleClass("active3");
    $(".hrLogin").toggleClass("active3");
    $(".mdpForget").toggleClass("active3");
    $(".card").toggleClass("active3");
    $(".card-header").toggleClass("active3");

    //! Account Moncompte    
    $(".menuCompte").toggleClass("active3");
    $(".lienMenuCompte").toggleClass("active3");
    $(".hrAbonnement").toggleClass("active3");
    $("th").toggleClass("active3");
    $("#file-ip-1-preview").toggleClass("active3");
    $(".inputBorder").toggleClass("active3");
    $(".conditionsGeneral").toggleClass("active3");
    $(".hrVertical").toggleClass("active3");
    $(".titreMission").toggleClass("active3");
    $(".lienSlug").toggleClass("active3");
    $("i.far.fa-eye").toggleClass("active3");
    $(".hrArticles").toggleClass("active3");
    $(".vl").toggleClass("active3");
    $("p.h4.titreCard").toggleClass("active3");
    $(".hauteurText").toggleClass("active3");
    $(".hrMonCompte").toggleClass("active3");
    $(".recherche").toggleClass("active3");
    $(".selectBord").toggleClass("active3");
    $(".imgSize").toggleClass("active3");
    $(".hrNewsletter").toggleClass("active3");
    $(".box").toggleClass("active3");
    $(".hrBox").toggleClass("active3");
    $(".hrProfil").toggleClass("active3");
    $("a.menuHamb").toggleClass("active3");
    $(".dropdown-submenu").toggleClass("active3");
    $("a.dropdown-item").toggleClass("active3");
    $(".fondColore").toggleClass("active3");
    $("#boomerangHeader").toggleClass("active3");
    $(".colorCommRechercheEtDev").toggleClass("active3");
    $(".colorImmobilier").toggleClass("active3");
    $(".colorEvolutionDesMetiers").toggleClass("active3");
    $(".colorSavoirs").toggleClass("active3");
    $(".colorInclusiveDesign").toggleClass("active3");
    $(".hrArticle").toggleClass("active3");
    $(".menu").toggleClass("active3");
    $(".lienUrl").toggleClass("active3");
    $(".grid figcaption").toggleClass("active3");
    $(".grid figcaption a").toggleClass("active3");
    $(".menuHamb").toggleClass("active3");
    $(".lienNoir").toggleClass("active3");
    $(".lienBlanc").toggleClass("active3");
    $(".navbar-light .navbar-nav .nav-link").toggleClass("active3");
    $(".grid figcaption a").toggleClass("active3");
    //! HomePage 
    $(".colorBlueGB").toggleClass("active3");
    $(".colorRedGB").toggleClass("active3");
    //! RetourExp
    $(".page-link.active3").toggleClass("active3");
    $("a").toggleClass("active3");
    $(".hauteurText").toggleClass("active3");
    $("i.fas.fa-user").toggleClass("active3");
    $("i.fas.fa-thumbs-up").toggleClass("active3");



  });
});

/****navbar dropdown lors du hober sur publication/partenaires et connexion  */

$(".dropdown").hover(function()
        {
            let dropdownMenu = $(this).children(".dropdown-menu");
            if(dropdownMenu.is("visible"))
            {
                dropdownMenu.parent().toggleClass("open");
            }
        });
/****------------------------------------------------------------------ */
/****------------------------------------------------------------------ */
/****------------------------------------------------------------------ */
/****------------------------------------------------------------------ */


/*********** tentative rétractation / apparition de la navbar selon le sens de scroll */
/*
var prevScrollPos = window.pageYOffset;
window.onscroll = function() {
  var currentScrollPos = window.pageYOffset;
  if (prevScrollPos > currentScrollPos) {
    document.getElementById("navAccessibilite").style.top = "0";
    document.getElementById("navDef1").style.top = "40px";
    document.getElementById("navbarDropdown3").style.top = "60px";
  } else {
    document.getElementById("navAccessibilite").style.top = "-40px";
    document.getElementById("navDef1").style.top = "-80px";
    document.getElementById("navbarDropdown3").style.top = "-60px";
  }
  prevScrollPos = currentScrollPos;
}
*/