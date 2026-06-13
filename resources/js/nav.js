import $ from 'jquery';

function setBurgerOpen(isOpen) {
    $('#burgerMenu').toggleClass('active', isOpen);
    $('#menuOverlay').toggleClass('active', isOpen);
    $('body').toggleClass('nav-drawer-open', isOpen);
    $('.app-bar__menu').attr('aria-expanded', isOpen ? 'true' : 'false');
}

$(document).on('click', '.toggle-burger-menu', function() {
    setBurgerOpen(!$('#burgerMenu').hasClass('active'));
});
