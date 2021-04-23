/* *********** */
/* Déclaration des variables globales */
/* *********** */

let copyright = '&copy; OpenStreetMap France | &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';
let coord = document.querySelectorAll('.item');
let nb = coord.length;
let map = L.map('mapid').setView([43.529742, 5.447427], 13);


/* *********** */
/* fonctions */
/* *********** */

/* Initialisation MAP */
function InitMap(){
    /* Affichage de la carte */
    map;
    /* Ajout du Layer OSM */
    L.tileLayer(
        'https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
            minzoom: 1,
            maxZoom: 20,
            attribution: copyright
        }).addTo(map);
    }
    
    /* Ajout des markers */
    function addMarker(){
        /* boucle pour afficher tous les poi retournés par la BDD + popup sur click */
        for (let i = 0; i < nb; i++) {
        let url = "details?id="+ coord[i].dataset.id;
        L.marker([parseFloat(coord[i].dataset.long), parseFloat(coord[i].dataset.lat)]).addTo(map).on('click', onClick);
        
        /*Ajout du popup au click avec Zoom et carte centrée*/
        function onClick(e) {
            
            L.popup()
            .setLatLng([parseFloat(coord[i].dataset.long), parseFloat(coord[i].dataset.lat)])
            .setContent(`<p>${coord[i].dataset.name} <br /> ${coord[i].dataset.type}</p> <br /> <a href="${url}" title="page de détails">Voir les détails</a>`)
        .openOn(map);
            
        /* Focus sur le POI sélectionné */
        map.setView([parseFloat(coord[i].dataset.long), parseFloat(coord[i].dataset.lat)], 17);
    }
}
};

/* *********** */
/* code Principal */
/* *********** */

window.addEventListener('DOMContentLoaded', ()=>{
    
    InitMap();
    addMarker();
});
