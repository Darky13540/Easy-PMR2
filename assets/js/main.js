/* *********** */
/* Déclaration des variables globales */
/* *********** */

/* MENU BURGER */
let content = document.querySelector('#hamburger-content');
let sidebarBody = document.querySelector('#hamburger-sidebar-body');
sidebarBody.innerHTML = content.innerHTML;
let button = document.querySelector('#hamburger-button');
let closeBurger = document.querySelector('#close-burger');
let activatedClass = 'hamburger-activated';
let hamburger = document.querySelector('#hamburger');



/* *********** */
/* code Principal */
/* *********** */
window.addEventListener('DOMContentLoaded', ()=>{
    
    /* menu burger open*/
    button.addEventListener('click', function(e){
        e.preventDefault();
        this.parentNode.classList.add(activatedClass);
    });
    
    closeBurger.addEventListener('click', function(e){
        e.preventDefault();
        hamburger.classList.remove(activatedClass);
    });
});
