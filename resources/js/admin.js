import $ from 'jquery';


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

        modal.classList.remove('hidden');

        modalContent.innerHTML = `
          <div class="flex items-center justify-center h-32">
            <svg class="animate-spin h-6 w-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
          </div>`;

        try {
            const response = await fetch(url, { 
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            if (!response.ok) throw new Error('Erreur de chargement');

            const html = await response.text();
            modalContent.innerHTML = html;
        } catch (error) {
            modalContent.innerHTML = `
              <div class="text-red-600 p-6">
                <p>❌ Erreur lors du chargement du contenu.</p>
              </div>`;
            console.error(error);
        }
    });

    // Fermeture modal
    closeBtn.addEventListener('click', () => modal.classList.add('hidden'));

    modal.addEventListener('click', (e) => {
        if (e.target === modal) modal.classList.add('hidden');
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
});