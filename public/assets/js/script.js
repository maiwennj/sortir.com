
function trLink(event,id){
    let viewportWidth = window.innerWidth || document.documentElement.clientWidth;
    if(viewportWidth<992){
        location.href= ""+id;

    }
}


function deleteEvent(event) {
    let confirmation = confirm('Êtes-vous sûr de vouloir supprimer ce brouillon ?');
    if (!confirmation) {
        event.preventDefault(); // Annuler le comportement par défaut du lien
    }
}

