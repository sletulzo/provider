import $ from 'jquery';

$(document).on('click', '.toggle-burger-menu', function() {
    $('#burgerMenu').toggleClass('active');
    $('#menuOverlay').toggleClass('active');
});
