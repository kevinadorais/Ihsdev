// VARIABLES

var readMoreButton = document.getElementById("readMoreButton");
var servicesText = document.getElementById("servicesText")

// FUNCTIONS

function displayText (event){
    event.preventDefault();
    servicesText.classList.remove("noDisplay");
    readMoreButton.classList.add("noDisplay");
}

// CODES

readMoreButton.addEventListener('click', displayText);