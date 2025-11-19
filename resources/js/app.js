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
    console.log("SPA navigation -> scripts reloaded");
});