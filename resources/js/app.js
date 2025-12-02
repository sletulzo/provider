import './transitions';

// -----------------------------------------------------------------------
// jQuery
// -----------------------------------------------------------------------
import $ from 'jquery';
window.$ = $;
window.jQuery = $;


// -----------------------------------------------------------------------
// Toastr
// -----------------------------------------------------------------------
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';
window.toastr = toastr;


// -----------------------------------------------------------------------
// SweetAlert2
// -----------------------------------------------------------------------
import Swal from 'sweetalert2';
window.Swal = Swal;


// -----------------------------------------------------------------------
// AJAX (CSRF token)
// -----------------------------------------------------------------------
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
});

// -----------------------------------------------------------------------
// Quill
// -----------------------------------------------------------------------
document.addEventListener('livewire:navigated', () => {
    const el = document.querySelector('#editor');
    if (el) {
        new Quill(el, { theme: 'snow' });
    }
});

// -----------------------------------------------------------------------
// Livewire
// -----------------------------------------------------------------------
document.addEventListener('livewire:navigated', () => {
    // Do nothing
});

// Livewire nav
document.querySelectorAll('.nav-item').forEach(item => {
    item.addEventListener('click', () => {
        item.classList.add('active');
    });
});