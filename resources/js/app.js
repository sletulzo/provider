import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Jquery
// -----------------------------------------------------------------------
import $ from 'jquery';
window.$ = window.jQuery = $;

// Toastr
// -----------------------------------------------------------------------
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';
window.toastr = toastr;

Alpine.start();

// Ajax setup
// -----------------------------------------------------------------------
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});