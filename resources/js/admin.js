import $ from 'jquery';

function themeColor() {
	return getComputedStyle(document.documentElement).getPropertyValue('--primary').trim() || '#3645b1';
}

const MODAL_LOADER = `
  <div class="ev-modal__loader">
    <span class="ev-modal__spinner"></span>
  </div>`;

function openAjaxModal(modal) {
    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden', 'false');
    document.body.classList.add('ev-modal-open');
}

function dismissAjaxModal(modal) {
    if (!modal || !modal.classList.contains('is-open')) return;
    modal.classList.remove('is-open');
    modal.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('ev-modal-open');
}

function initAjaxModal() {
    const modal = document.getElementById('ajaxModal');
    const modalContent = document.getElementById('ajaxModalContent');
    const closeBtn = document.getElementById('closeModalBtn');

    if (!modal || modal.__ajaxModalInit) return;

    // Marqueur pour éviter double initialisation
    modal.__ajaxModalInit = true;

    // Handler d’ouverture (délégué pour fonctionner en SPA)
    document.addEventListener('click', async (e) => {
        const link = e.target.closest('a.ajax-modal');
        if (!link) return;

        e.preventDefault();
        const url = link.getAttribute('href');

        openAjaxModal(modal);
        modalContent.innerHTML = MODAL_LOADER;

        try {
            const response = await fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            if (!response.ok) throw new Error('Erreur de chargement');

            const html = await response.text();
            modalContent.innerHTML = html;
        } catch (error) {
            modalContent.innerHTML = `
              <div class="ev-modal__error">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <p>Erreur lors du chargement du contenu.</p>
              </div>`;
            console.error(error);
        }
    });

    // Fermeture modal
    closeBtn.addEventListener('click', () => dismissAjaxModal(modal));

    modal.addEventListener('click', (e) => {
        if (e.target === modal) dismissAjaxModal(modal);
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') dismissAjaxModal(modal);
    });
}

document.addEventListener('livewire:navigated', initAjaxModal);

// ---------------------------------------------------------------------------------
// ------------------------------------ QUILL --------------------------------------
// ---------------------------------------------------------------------------------
function initQuillEditors() {
    $('.quill-editor').each(function () {
        var editorEl = this;

        // Initialise Quill
        var quill = new Quill(editorEl, {
            theme: 'snow'
        });

        // Trouve l'input hidden à côté
        var hiddenInput = $(editorEl).parent().find('input[name="email_content"]');
        if (!hiddenInput.length) return;

        // Précharge le contenu initial
        hiddenInput.val(quill.root.innerHTML);

        // Synchronise à chaque changement
        quill.on('text-change', function () {
            hiddenInput.val(quill.root.innerHTML);
        });
    });
}

// Ré-initialisation après navigation SPA Livewire
document.addEventListener('livewire:navigated', initQuillEditors);

// ---------------------------------------------------------------------------------
// ---------------------------------- NAV TABS -------------------------------------
// ---------------------------------------------------------------------------------
$(document).on('click', '.tabs-nav button', function() {
    var tabId = $(this).data('tab');
    var container = $(this).closest('.tabs');

    container.find('.tabs-nav button').removeClass('active');
    container.find('.tab-pane').removeClass('active');

    // Active le bouton cliqué
    $(this).addClass('active');

    // Affiche le bon contenu
    container.find('#' + tabId).addClass('active');
});

// ---------------------------------------------------------------------------------
// --------------------------- Update order quantity -------------------------------
// ---------------------------------------------------------------------------------
$(document).on('change', 'input[name="update-order-quantity"]', function(e) {
    e.preventDefault();
    e.stopPropagation();

    var value = $(this).val();
    var url = $(this).attr('data-url');
    var tr = $(this).closest('tr');
    var id = tr.attr('data-id');

    $.ajax({
      method: "POST",
      url: url,
      data: {
        value: value
      }
    }).done(function() {
      toastr.success('Mise à jour réussie.');
      updateSection('sectionOrderEmail');

      setTimeout(function() {
        initQuillEditors();
      }, 200);
	})
});


// ---------------------------------------------------------------------------------
// ----------------------- Update provider product select --------------------------
// ---------------------------------------------------------------------------------
$(document).on('change', '#selectProviderProduct', function(e) {
	e.preventDefault();
	e.stopPropagation();

	var provider_id = $(this).val();
	var form = $(this).closest('form');
	var url = form.attr('action');
	var container = form.find('.container-provider-products');

	$.ajax({
		method: "POST",
		url: url,
		data: {
			provider_id: provider_id
		}
	}).done(function(view) {
		container.html(view);
	})
})

// ---------------------------------------------------------------------------------
// ------------------- Update input product provider quantity ----------------------
// ---------------------------------------------------------------------------------
$(document).on('change', '.input-provider-product-update', function(e) {
    e.preventDefault();
    e.stopPropagation();

    var url = $(this).attr('data-url');
    var quantity = $(this).val();

    $.ajax({
        method: 'POST',
        url: url,
        data: {
          quantity: quantity
        }
    }).done(function() {
      toastr.success('Mise à jour réussie.');
      updateSection('sectionOrderWaiting');
      updateSection('sectionOrderEmail');

      setTimeout(function() {
        initQuillEditors();
      }, 200);
	})
});

// ---------------------------------------------------------------------------------
// -------------------------- Section order waiting --------------------------------
// ---------------------------------------------------------------------------------
function updateSection(id) {
	var section = $('section#' + id);

	if (section.length) {
		var url = section.attr('data-url');

		$.ajax({
			method: 'POST',
			url: url
		}).done(function(view) {
			section.replaceWith(view);
		});
	}
}

// ---------------------------------------------------------------------------------
// -------------------------- Increment & decrement --------------------------------
// ---------------------------------------------------------------------------------
$(document).on('click', '.increment', function(e) {
	e.preventDefault();
	e.stopPropagation();

	var type = $(this).attr('data-type');
	var target = $(this).attr('data-target');
	var parent = $(this).parent();
	var input = parent.find('.' + target);

	if (input.length) {
		var value = input.val() == '' ? 0 : parseInt(input.val());
		var newValue = type == 'minus' ? value-1 : value+1;

		if (newValue < 0)
			newValue = 0;
		
		input.val(newValue);
		input.trigger('change');
	}
});

// ---------------------------------------------------------------------------------
// ------------------------------- Responsive menu ---------------------------------
// ---------------------------------------------------------------------------------
$(document).on('click', '.nav-mobile-icon', function() {
    $('.main-wrapper').toggleClass('open-menu');
    $('.nav-mobile').toggleClass('active');
});

$(document).on('click', function(e) {
    if ($('.nav-mobile').hasClass('active')) {
        if (!$(e.target).closest('.nav-mobile, .nav-mobile-icon').length) {
            $('.main-wrapper').removeClass('open-menu');
            $('.nav-mobile').removeClass('active');
        }
    }
});


// ---------------------------------------------------------------------------------
// ---------------------------- Search inside table --------------------------------
// ---------------------------------------------------------------------------------
$(document).on('keyup', 'input[name="search-table"]', function () {
    let value = $(this).val().toLowerCase();

    $('.table tbody tr').filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });

	$('.card-mobile-content-name').filter(function () {
        $(this).closest('.card-mobile').toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
});


// ---------------------------------------------------------------------------------
// ----------------------------------- DELETE --------------------------------------
// ---------------------------------------------------------------------------------
$(document).on('click', 'a.confirm-delete', function(e) {
    e.preventDefault();
    e.stopPropagation();

	var url = $(this).attr('href');
	var remove = $(this).attr('data-remove');
	var line = $(this).closest('.' + remove);

    Swal.fire({
		title: "Supprimer cet élément ?",
		text: "Cette action est irréversible.",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Oui, supprimer",
		cancelButtonText: "Annuler",
		confirmButtonColor: themeColor(),
    	cancelButtonColor: "#ddd"
	}).then((result) => {
		if (result.isConfirmed) {
			if (line.length) {
				$.ajax({
					method: 'GET',
					url: url
				}).done(function() {
					toastr.clear();
					toastr.success('Vous venez de supprimer un élément', 'Succès');
					line.remove();
				});
			} else {
				window.location.href = url;
			}
		}
	});
});


// ---------------------------------------------------------------------------------
// -------------------------------- GLOABl SWAL ------------------------------------
// ---------------------------------------------------------------------------------
$(document).on('click', 'a.confirm-validate', function(e) {
    e.preventDefault();
    e.stopPropagation();

	var url = $(this).attr('href');
	var text = $(this).attr('data-text');
	var type = $(this).attr('data-type');

    Swal.fire({
		title: "Confirmer l'action",
		text: text,
		icon: type,
		showCancelButton: true,
		confirmButtonText: "Oui, je confirme",
		cancelButtonText: "Annuler",
		confirmButtonColor: themeColor(),
    	cancelButtonColor: "#ddd"
	}).then((result) => {
		if (result.isConfirmed) {
			window.location.href = url;
		}
	});
});

// ---------------------------------------------------------------------------------
// --------------------------- Ajax modal up and down ------------------------------
// ---------------------------------------------------------------------------------
function closeModalSlideUp() {
	var modal = $('#ajaxModalSlideUp');
	$('body').removeClass('backdrop');
	modal.removeClass('active large is-dragging');
	modal.css({ transform: '', transition: '' });
}

function closeAjaxModal() {
	var modal = document.getElementById('ajaxModal');
	if (modal) {
		dismissAjaxModal(modal);
	}
}

function closeAllModals() {
	closeModalSlideUp();
	closeAjaxModal();
}

function initModalSlideUpSwipe() {
	var modal = document.getElementById('ajaxModalSlideUp');
	if (!modal || modal.dataset.swipeBound === '1') {
		return;
	}

	modal.dataset.swipeBound = '1';

	var startY = 0;
	var dragY = 0;
	var isDragging = false;
	var activeScroll = null;

	function getDragZone(target) {
		return target.closest('[data-modal-drag-handle], .cart-v2__chrome, .cart-v2__drag, .cart-v2__handle');
	}

	function getScrollable(target) {
		return target.closest('.cart-v2__items, .cart-v2__scroll');
	}

	modal.addEventListener('touchstart', function(e) {
		if (!modal.classList.contains('active')) {
			return;
		}

		var touch = e.touches[0];
		var zone = getDragZone(e.target);
		activeScroll = getScrollable(e.target);

		if (activeScroll && activeScroll.scrollTop > 5) {
			return;
		}

		if (!zone && !activeScroll) {
			var rect = modal.getBoundingClientRect();
			if (touch.clientY - rect.top > 64) {
				return;
			}
		}

		startY = touch.clientY;
		dragY = 0;
		isDragging = true;
		modal.classList.add('is-dragging');
	}, { passive: true });

	modal.addEventListener('touchmove', function(e) {
		if (!isDragging) {
			return;
		}

		if (activeScroll && activeScroll.scrollTop > 5) {
			isDragging = false;
			modal.classList.remove('is-dragging');
			modal.style.transform = '';
			return;
		}

		var y = e.touches[0].clientY;
		dragY = Math.max(0, y - startY);

		if (dragY > 0) {
			e.preventDefault();
			modal.style.transform = 'translateY(' + dragY + 'px)';
		}
	}, { passive: false });

	function endDrag() {
		if (!isDragging) {
			return;
		}

		isDragging = false;
		modal.classList.remove('is-dragging');

		var threshold = Math.min(120, modal.offsetHeight * 0.18);

		if (dragY > threshold) {
			modal.style.transition = 'transform 0.22s ease-out';
			modal.style.transform = 'translateY(100%)';
			window.setTimeout(closeModalSlideUp, 220);
		} else {
			modal.style.transition = 'transform 0.22s ease-out';
			modal.style.transform = '';
			window.setTimeout(function() {
				modal.style.transition = '';
			}, 220);
		}

		dragY = 0;
		activeScroll = null;
	}

	modal.addEventListener('touchend', endDrag);
	modal.addEventListener('touchcancel', endDrag);
}

$(document).on('click', '.ajax-modal-up', function(e) {
	e.preventDefault();
	e.stopPropagation();

	var url = $(this).attr('href');
	var modal = $('#ajaxModalSlideUp');
	var size = $(this).attr('data-size');
	var method = $(this).attr('data-method') ?? 'POST';
	var modalContent = modal.find('#ajaxModalSlideUpContent');
	var body = $('body');

	modal.css({ transform: '', transition: '' });

	modalContent.html( `
		<div class="flex items-center justify-center h-32">
		<svg class="animate-spin h-6 w-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
			<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
			<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
		</svg>
		</div>`);
	
  
	modal.removeClass('large is-dragging');
	modal.addClass('active');
	body.addClass('backdrop');
	modal.addClass(size);

	$.ajax({
		method: method,
		url: url
	}).done(function(view) {
		modalContent.html(view);
	});
});

// Close modal
$(document).on('click', '.close-modal-up', function(e) {
	closeModalSlideUp();
});

$(document).on('click', '.close-modal-all', function(e) {
	e.preventDefault();
	closeAllModals();
});

$(function() {
	initModalSlideUpSwipe();
});


// ---------------------------------------------------------------------------------
// ------------------------------- TRIGGER UPDOWN ----------------------------------
// ---------------------------------------------------------------------------------
$(document).on('click', '.trigger-updown', function(e) {
	e.preventDefault();
	e.stopPropagation();

	var updown = $(this).closest('.updown');
	var type = $(this).attr('data-type');
	var url = updown.attr('data-url');
	var item = $(this).closest('.indent-container-right-item, .indent-v2__product');
	var display = updown.find('.updown-display');
  	var popup = $('.indent-order-popup');
  	var stickyCart = $('.indent-v2__sticky-cart');

  	if (parseInt(display.html()) == 0 && type == 'remove')
		return;

	$.ajax({
		method: "POST",
		url: url,
		data: {
			type: type
		}
	}).done(function(data) {
		$('#indentOrderCount').html(data.count);
		display.html(data.value);
		item.toggleClass('active', data.value <= 0 ? false : true);
    	popup.toggleClass('active', data.count > 0 ? true : false);
    	stickyCart.toggleClass('active', data.count > 0 ? true : false);
    	if (stickyCart.length && data.total !== undefined) {
    		stickyCart.find('.indent-v2__sticky-cart-total').text(data.total);
    		stickyCart.find('.indent-v2__sticky-cart-label').text('Panier · ' + data.count + ' article' + (data.count > 1 ? 's' : ''));
    	}
	});
});

// ---------------------------------------------------------------------------------
// ----------------------- Partage tarifs fournisseur ------------------------------
// ---------------------------------------------------------------------------------
$(document).on('click', '#copyProviderPricesUrl', function () {
	var btn = this;
	var input = document.getElementById($(btn).data('target') || 'providerPricesUrl');
	if (!input) return;

	input.select();
	input.setSelectionRange(0, 99999);

	function feedback() {
		btn.innerHTML = '<i class="fa-solid fa-check"></i> Copié';
		setTimeout(function () {
			btn.innerHTML = '<i class="fa-regular fa-copy"></i> Copier';
		}, 2000);
	}

	if (navigator.clipboard) {
		navigator.clipboard.writeText(input.value).then(feedback);
	} else {
		document.execCommand('copy');
		feedback();
	}
});

$(document).on('click', '#sendProviderPricesLink', function () {
	var btn = this;
	var url = $(btn).data('url');
	var form = document.getElementById($(btn).data('form') || 'providerForm');
	if (!url || !form) return;

	if (!confirm('Envoyer le lien de mise à jour des tarifs par e-mail ?')) {
		return;
	}

	var token = form.querySelector('input[name="_token"]').value;

	fetch(url, {
		method: 'POST',
		headers: {
			'Content-Type': 'application/x-www-form-urlencoded',
			'X-Requested-With': 'XMLHttpRequest',
			'Accept': 'text/html',
		},
		body: '_token=' + encodeURIComponent(token),
	}).then(function (response) {
		if (response.redirected) {
			window.location.href = response.url;
		}
	});
});

// ---------------------------------------------------------------------------------
// ------------------------------- LOADER BUTTON -----------------------------------
// ---------------------------------------------------------------------------------
$(document).on('submit', 'form', function(e) {
	let $btn = $(this).find('button[type="submit"], input[type="submit"]');

	if ($btn.length) {
		$btn.addClass('is-loading');
		$btn.prop('disabled', true);
	}
});


// ---------------------------------------------------------------------------------
// -------------------------------- Collapse open ----------------------------------
// ---------------------------------------------------------------------------------
$(document).on('click', '.swiftopen-toggle', function () {

	var id = $(this).attr('data-target');
	var content = $('.swiftopen-content#' + id);
	const isOpen = content.hasClass('is-open');

	if (isOpen) {
		content.removeClass('is-open');
	} else {
		content.addClass('is-open');
	}
});


// ---------------------------------------------------------------------------------
// -------------------------------- Order search -----------------------------------
// ---------------------------------------------------------------------------------
document.addEventListener('DOMContentLoaded', function () {
    const container = document.querySelector('.orders-months');
    if (!container) return;

    const active = document.querySelector('.orders-month-item.active');
    const fallback = document.querySelector('.orders-month-item[data-month="' + new Date().getMonth()+1 + '"]');

    const target = active || fallback;
    if (!target) return;

    const containerWidth = container.offsetWidth;

    container.scrollTo({
        left: target.offsetLeft - (containerWidth / 2) + (target.offsetWidth / 2),
        behavior: 'smooth'
    });
});

function setMonth(month) {
    document.getElementById('month-input').value = month;
    document.querySelector('.orders-filters').submit();
}

function initIndentProductSearch() {
    const search = document.getElementById('indentProductSearch');
    const list = document.getElementById('indentProductList');
    if (!search || !list) return;

    const input = search.tagName === 'INPUT' ? search : search.querySelector('input');
    if (!input || input.__indentSearchInit) return;
    input.__indentSearchInit = true;

    input.addEventListener('input', () => {
        const query = input.value.trim().toLowerCase();
        list.querySelectorAll('.indent-v2__product').forEach((row) => {
            const name = row.getAttribute('data-product-name') || '';
            row.style.display = !query || name.includes(query) ? '' : 'none';
        });
    });
}

document.addEventListener('DOMContentLoaded', initIndentProductSearch);
document.addEventListener('livewire:navigated', initIndentProductSearch);