import $ from 'jquery';

function setBurgerOpen(isOpen) {
    $('#burgerMenu').toggleClass('active', isOpen);
    $('#menuOverlay').toggleClass('active', isOpen);
    $('body').toggleClass('nav-drawer-open', isOpen);
    $('.app-bar__menu').attr('aria-expanded', isOpen ? 'true' : 'false');
}

$(document).on('click', '.open-burger-menu', function (e) {
    e.preventDefault();
    setBurgerOpen(true);
});

$(document).on('click', '.close-burger-menu', function (e) {
    e.preventDefault();
    e.stopPropagation();
    setBurgerOpen(false);
});

document.addEventListener('livewire:navigated', () => {
    setBurgerOpen(false);
});
