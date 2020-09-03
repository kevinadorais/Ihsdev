window.onload = () => {

    // Variables ////////////////////////////////////////////////////////
    let deleteLinks = document.querySelectorAll("[data-delete]")

    // On boucle sur deleteLinks
    for (link of deleteLinks) {
        // On ecoute le click
        link.addEventListener("click", function(e){
            // on enleve les event par default
            e.preventDefault()
            // Verification avec une confirmation
            if(confirm("Voulez-vous supprimer l\'image ?")){
                //On envoie une requête ajax vers le href du lien avec la methode delete
                fetch(this.getAttribute("href"), {
                    method: "DELETE",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({"_token": this.dataset.token})
                }).then(
                    // On recupère la reponse en json
                    response => response.json()
                ).then(data => {
                    if(data.success){
                        this.parentElement.remove()
                    }     
                    else{
                        alert(data.error)
                    }  
                }).catch(e => alert(e))
            }
        })
    }
}