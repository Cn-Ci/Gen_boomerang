/* Gestion du contraste */
if(getCookie("acceptCookieUrbilog") === ""){
    document.querySelector("#bandeauCookie").style.display="block";
    document.querySelector("#bandeauCookie").style.position="fixed";
    document.querySelector("#bandeauCookie").focus();
}else if(getCookie("contrastUrbilog") === "true"){
  addClass(document.body ,'contraste');
  setTimeout(function () {
    document.querySelector("#btnContrast").innerHTML="<span>version</br>standard</span>";
    document.querySelector("#btnContrastRapide").innerHTML="version standard";
    document.querySelector("#btnContrast").title="Passer en version standard";
    document.querySelector("#btnContrastRapide").title="Passer en version standard";
  }, 300);
}


if(getCookie("acceptCookieUrbilog")){
  /* Gestion de la police dyslexique */
  if(getCookie("dyslexicFont") === "true"){
    /* ajout class dyslexique sur body */
    setCookie("dyslexicFont", true, 365);
    addClass(document.body ,'dyslexicFont');
    setTimeout(function () {
      document.querySelector("#btnDyslexicFont").innerHTML="<span>Police</br>standard</span>";
      document.querySelector("#btnDyslexicFont").title="Activer la police standard";
      document.querySelector("#incrCharSize").src="../../images/A+Dyslexique.png";
      document.querySelector("#decrCharSize").src="../../images/A-Dyslexique.png";
    }, 10);
  }

  /* Gestion de la taille de la police */
  if(getCookie("charSize") === "charSizeIncr1"){
    /* ajout class charSizeIncr1 sur body */
    addClass(document.body ,'charSizeIncr1');
  }

  /* Gestion de la taille de la police */
  if(getCookie("charSize") === "charSizeIncr2"){
    /* ajout class dyslexique sur body */
    addClass(document.body ,'charSizeIncr2');
    setTimeout(function () {
      console.log(document.querySelector("footer"));
      document.querySelector("#incrCharSize").disabled=true;
    }, 300);
  }

  /* Gestion de la taille de la police */
  if(getCookie("charSize") === ""){
    setTimeout(function () {
      if(document.querySelector("#decrCharSize")){
        document.querySelector("#decrCharSize").disabled=true;
      }
    }, 300);
  }
}

/* FONCTIONS */
/* Permet d'activer / désactiver le mode contrasté */
function setContrast(){
  /* Passage en mode contrasté */
  /* Si il à accepté les cookies et que le mode contraste n'est pas activé */
  if(getCookie("acceptCookieUrbilog") && (getCookie("contrastUrbilog") === "false")){
    /* ajout class contrast sur body */
    setCookie("contrastUrbilog", true, 365);
    addClass(document.body ,'contraste');
    document.querySelector("#btnContrast").innerHTML="<span>version</br>standard</span>";
    document.querySelector("#btnContrastRapide").innerHTML="version standard";
    document.querySelector("#btnContrast").title="Passer en version standard";
    document.querySelector("#btnContrastRapide").title="Passer en version standard";
  }
  /* Si le mode contraste est activé on le désactive */
  else if(getCookie("contrastUrbilog") === "true"){
    /* Enlève class contrast du body */
    removeClass(document.body ,'contraste');
    setCookie("contrastUrbilog", false, 365);
    document.querySelector("#btnContrast").innerHTML="<span>version contrastée</span>";
    document.querySelector("#btnContrastRapide").innerHTML="version contrastée";
    document.querySelector("#btnContrast").title="Passer en version contrastée";
    document.querySelector("#btnContrastRapide").title="Passer en version contrastée";
  }
}

/* Permet d'activer / désactiver la police openDyslexic */
function setDyslexic(){
  /* Passage en mode dyslexique */
  /* Si il à accepté les cookies et que le mode dyslexique n'est pas activé */
  if((getCookie("acceptCookieUrbilog") && getCookie("dyslexicFont") === "false") || (getCookie("acceptCookieUrbilog") && getCookie("dyslexicFont") === "")){
    /* ajout class dyslexique sur body */
    setCookie("dyslexicFont", true, 365);
    addClass(document.body ,'dyslexicFont');
    document.querySelector("#btnDyslexicFont").innerHTML="<span>Police</br>standard</span>";
    document.querySelector("#btnDyslexicFont").title="Activer la police standard";
    document.querySelector("#incrCharSize").src="../../images/A+Dyslexique.png";
    document.querySelector("#decrCharSize").src="../../images/A-Dyslexique.png";
  }
  /* Si le mode dyslexique est activé on le désactive */
  else if(getCookie("dyslexicFont") === "true"){
    /* Enlève class dyslexique du body */
    removeClass(document.body ,'dyslexicFont');
    setCookie("dyslexicFont", false, 365);
    document.querySelector("#btnDyslexicFont").innerHTML="<span>Police</br>dyslexique</span>";
    document.querySelector("#btnDyslexicFont").title="Activer la police d'aides aux dyslexiques";
    document.querySelector("#incrCharSize").src="../../images/A+.png";
    document.querySelector("#decrCharSize").src="../../images/A-.png";
  }
}

function acceptCookies(){
  setCookie("acceptCookieUrbilog", "true", 365);
  setCookie("contrastUrbilog", "false", 365);
  setCookie("dyslexicFont", "false", 365);
  setCookie("charSize", "", 365);
  document.querySelector("#bandeauCookie").style.height=0;
  setTimeout(function () {
    document.querySelector("#bandeauCookie").style.display="none";
  }, 401);
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires + "; path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    }
    return "";
}

function hasClass(elem, className) {
    return new RegExp(' ' + className + ' ').test(' ' + elem.className + ' ');
}

function addClass(elem, className) {
    if (!hasClass(elem, className)) {
        elem.className += ' ' + className;
    }
}

function removeClass(elem, className) {
    var newClass = ' ' + elem.className.replace( /[\t\r\n]/g, ' ') + ' ';
    if (hasClass(elem, className)) {
        while (newClass.indexOf(' ' + className + ' ') >= 0 ) {
            newClass = newClass.replace(' ' + className + ' ', ' ');
        }
        elem.className = newClass.replace(/^\s+|\s+$/g, '');
    }
}

/* Footer */
function scrollHaut(){
  setTimeout(function () {
    window.scrollTo(1,1);
  }, 10);
  verifContrast();
}
/* !Footer */

/* Header */
function verifContrast(){
  if(getCookie("contrastUrbilog") === "true"){
    setTimeout(function () {
      document.querySelector("#btnContrast").innerHTML="version standard";
      document.querySelector("#btnContrastRapide").innerHTML="version standard";
    }, 300);
  }
}

var hamburgerIsOpen = false;
function manageHamburger(){
  if(hamburgerIsOpen){
    hideMenuBurger();
  }else{
    showMenuBurger();
  }
}

function hideMenuBurger(){
  removeClass(document.getElementsByTagName('body')[0],'stopScroll');
  addClass(document.getElementsByTagName('header')[0],'closeBurger');
  removeClass(document.getElementsByTagName('header')[0],'openBurger');
  hamburgerIsOpen=false;
  // On démasque tous les liens du contenu
  document.querySelector("h1").removeAttribute("aria-hidden");
  document.querySelector("h1").setAttribute("tabindex","0");
  var part = document.querySelectorAll(".part *:not(.leafletContainer)");
  part.forEach(function(e){
    e.removeAttribute("aria-hidden");
    e.removeAttribute("tabindex");
  });
  // On masque tous les liens du footer
  document.querySelector("footer").removeAttribute("aria-hidden");
  var lienFooter = document.querySelectorAll("footer *");
  lienFooter.forEach(function(elmt){
    elmt.removeAttribute("tabindex");
  });
  // il reste juste le lien d'ouverture menu
  document.querySelector("a#ouvrirMenu").removeAttribute("aria-hidden");
  document.querySelector("a#ouvrirMenu").removeAttribute("tabindex");
  //...et les liens d'accès rapide
  var accesRapide = document.querySelectorAll(".accesRapide a");
  accesRapide.forEach(function(elmt){
    elmt.removeAttribute("aria-hidden");
    elmt.removeAttribute("tabindex");
  });
}

function showMenuBurger(){
  addClass(document.getElementsByTagName('body')[0],'stopScroll');
  addClass(document.getElementsByTagName('header')[0],'openBurger');
  removeClass(document.getElementsByTagName('header')[0],'closeBurger');
  hamburgerIsOpen=true;
  // focus sur le premier lien du menu
  focusPopIn();
  // On masque tous les liens du contenu
  document.querySelector("h1").setAttribute("aria-hidden","true");
  document.querySelector("h1").setAttribute("tabindex","0");
  var part = document.querySelectorAll(".part *");
  part.forEach(function(e){
    e.setAttribute("aria-hidden","true");
    e.setAttribute("tabindex","-1");
  });
  // On masque tous les liens du footer
  document.querySelector("footer").setAttribute("aria-hidden","true");
  var lienFooter = document.querySelectorAll("footer *");
  lienFooter.forEach(function(elmt){
    elmt.setAttribute("tabindex","-1");
    elmt.setAttribute("aria-hidden","true");
  });
  // il reste juste le lien d'ouverture menu
  document.querySelector("a#ouvrirMenu").setAttribute("aria-hidden","true");
  document.querySelector("a#ouvrirMenu").setAttribute("tabindex","0");
  //...et les liens d'accès rapide
  var accesRapide = document.querySelectorAll(".accesRapide a");
  accesRapide.forEach(function(elmt){
    elmt.setAttribute("aria-hidden","true");
    elmt.setAttribute("tabindex","-1");
  });

  // Sur le blur du dernier lien
  document.querySelector("#lastLinkBurger").addEventListener("blur", function( event ) {
    setTimeout(function () {
      // console.log(document.activeElement);
      if(hasClass(document.activeElement,"containerHamburger")){
        document.querySelector("#fermerMenu").focus();
      }
    }, 10);
  }, true);

  // Sur le blur (shift + tab) du premier lien
  document.querySelector("#fermerMenu ").addEventListener("blur", function( event ) {
    setTimeout(function () {
      if(hasClass(document.activeElement,"menuLienAccueil")){
        document.querySelector("#lastLinkBurger").focus();
      }
    }, 10);
  }, true);
}

document.addEventListener('keyup',function(ev) {
    if (ev.which == 27) {
      hideMenuBurger();
    }
});

function focusPopIn(){
  document.querySelector("#fermerMenu").focus();
}

function focusEndPopIn(){
  document.querySelector("#listeMenu > li > a").focus();
}

function removeStopScroll(){
    removeClass(document.getElementsByTagName('body')[0],'stopScroll');
    verifContrast();
}

function init() {
    window.addEventListener('scroll', function(e){
        var distanceY = window.pageYOffset || document.documentElement.scrollTop,
            shrinkOn = 150,
            header = document.querySelector("header");
        if(header){
          if (distanceY > shrinkOn) {
              addClass(header,"smaller");
          } else {
              if (hasClass(header,"smaller")) {
                  removeClass(header,"smaller");
              }
          }
        }
    });
}

function shuffle(o){
   for(var j, x, i = o.length; i; j = Math.floor(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
   return o;
}
window.onload = init();
/* ! Header*/
/* agence/realisations */

function scrollTo(element, to, duration) {
  if (duration <= 0) return;
  var difference = to - element.scrollTop;
  var perTick = difference / duration * 10;

  setTimeout(function() {
    element.scrollTop = element.scrollTop + perTick;
    if (element.scrollTop == to) return;
    scrollTo(element, to, duration - 10);
  }, 10);
}
/* ! agence/realisations */

/* Donne le focus au premier H1 de la page ou a l'élément donné en paramètre*/
function focus(elmt){
  var focus = elmt != null ? elmt : "h1";
  setTimeout(function () {
    document.querySelector(focus).focus();
  }, 150);
  return true
}

/* Augmenter la police */
function augmenterPolice(){
  var body = document.querySelector("body");
  if(hasClass(body,"charSizeIncr1")){
    setCookie("charSize", "charSizeIncr2", 365);
    removeClass(body,"charSizeIncr1");
    addClass(body,"charSizeIncr2");
    document.querySelector("#incrCharSize").disabled=true;
  }else if(!hasClass(body,"charSizeIncr2")){
    setCookie("charSize", "charSizeIncr1", 365);
    addClass(body,"charSizeIncr1");
    document.querySelector("#decrCharSize").disabled=false;
  }
}
/* Augmenter la police */
function diminuerPolice(){
  var body = document.querySelector("body");
  if(hasClass(body,"charSizeIncr2")){
    setCookie("charSize", "charSizeIncr1", 365);
    removeClass(body,"charSizeIncr2");
    addClass(body,"charSizeIncr1");
    document.querySelector("#incrCharSize").disabled=false;
  }else if(hasClass(body,"charSizeIncr1")){
    setCookie("charSize", "", 365);
    removeClass(body,"charSizeIncr1");
    document.querySelector("#decrCharSize").disabled=true;
  }
}


// var pattern = new RegExp("urbilog.fr");
var pattern = new RegExp("urbilog.fr");
// var pat2 =
var prod = false;
if(pattern.test(window.location.href)){
  prod = true;
}