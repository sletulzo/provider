import './transitions';
import './push';

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

const toastIconClasses = {
    success: 'fa-solid fa-circle-check',
    error: 'fa-solid fa-circle-xmark',
    info: 'fa-solid fa-circle-info',
    warning: 'fa-solid fa-triangle-exclamation',
};

function patchToastIcon(toastEl) {
    if (!toastEl || toastEl.querySelector('.vinste-toast__icon')) {
        return;
    }

    const type = ['success', 'error', 'info', 'warning'].find((name) => toastEl.classList.contains(`toast-${name}`));
    const iconClass = toastIconClasses[type] || toastIconClasses.info;

    const icon = document.createElement('span');
    icon.className = 'vinste-toast__icon';
    icon.setAttribute('aria-hidden', 'true');
    icon.innerHTML = `<i class="${iconClass}"></i>`;
    toastEl.insertBefore(icon, toastEl.firstChild);
}

function ensureToastObserver() {
    const container = document.getElementById('toast-container');
    if (!container) {
        return;
    }

    container.querySelectorAll('.toast').forEach(patchToastIcon);

    if (container.dataset.vinsteIconsBound === '1') {
        return;
    }

    container.dataset.vinsteIconsBound = '1';

    new MutationObserver(() => {
        container.querySelectorAll('.toast').forEach(patchToastIcon);
    }).observe(container, { childList: true });
}

function wrapToastrMethods() {
    if (toastr.__vinsteWrapped) {
        return;
    }

    toastr.__vinsteWrapped = true;

    ['success', 'error', 'info', 'warning'].forEach((method) => {
        const original = toastr[method].bind(toastr);
        toastr[method] = function (...args) {
            const result = original(...args);
            requestAnimationFrame(ensureToastObserver);
            return result;
        };
    });
}

function initToastr() {
    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: 'toast-top-right',
        timeOut: 4500,
        extendedTimeOut: 1500,
        showMethod: 'fadeIn',
        hideMethod: 'fadeOut',
        tapToDismiss: true,
        newestOnTop: true,
        onShown: function () {
            patchToastIcon(this);
        },
    };

    wrapToastrMethods();
    ensureToastObserver();
}

initToastr();
document.addEventListener('livewire:navigated', initToastr);


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
    window.toastr = toastr;
});

// Livewire nav
document.querySelectorAll('.nav-item').forEach(item => {
    item.addEventListener('click', () => {
        item.classList.add('active');
    });
});