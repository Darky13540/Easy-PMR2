/* *********** */
/* Déclaration des variables globales */
/* *********** */
let copyright = '&copy; OpenStreetMap France | &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';
let coord = document.querySelectorAll('.item');
let nb = coord.length;
let map = L.map('mapid').setView([43.529742, 5.447427], 12);


/* *********** */
/* fonctions */
/* *********** */
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

function addMarker(){
    /* boucle pour afficher tous les poi retournés par la BDD + popup sur click */
for (let i = 0; i < nb; i++) {
    L.marker([parseFloat(coord[i].dataset.long), parseFloat(coord[i].dataset.lat)]).addTo(map).on('click', onClick);
    /*Ajout du popup au click avec Pan*/
    function onClick(e) {
        L.popup()
            .setLatLng([parseFloat(coord[i].dataset.long), parseFloat(coord[i].dataset.lat)])
            .setContent("<p>" + coord[i].dataset.name + "<br />" + coord[i].dataset.type + "</p>")
            .openOn(map);
        map.panTo([parseFloat(coord[i].dataset.long), parseFloat(coord[i].dataset.lat)]);
            
        }
    }
}
/* *********** */
/* code Principal */
/* *********** */
window.addEventListener('DOMContentLoaded', ()=>{


/* Initialisation de la carte et chargement des layers OSMFR centré sur Aix en Provence*/

InitMap();
addMarker();


});