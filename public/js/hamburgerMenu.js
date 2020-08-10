// Variables

var menuButton = document.getElementById('menuButton');
var navBar = document.getElementById('navBar');

// Fonctions

function navDisplay (event){
    event.preventDefault();
    navBar.classList.toggle('noNavBar');
    }

// Code

menuButton.addEventListener('click', navDisplay);