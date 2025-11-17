document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('ajaxModal');
  const modalContent = document.getElementById('ajaxModalContent');
  const closeBtn = document.getElementById('closeModalBtn');

  // ✅ Ouverture de la modal via un lien
  document.querySelectorAll('a.ajax-modal').forEach(link => {
    link.addEventListener('click', async (e) => {
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
        const response = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' }});
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
  });

  // ✅ Fermeture de la modal
  closeBtn.addEventListener('click', () => modal.classList.add('hidden'));

  // ✅ Fermer si clic en dehors
  modal.addEventListener('click', (e) => {
    if (e.target === modal) modal.classList.add('hidden');
  });
});


document.addEventListener('DOMContentLoaded', () => {
    // Sélecteur du select produit
    const productSelect = document.querySelector('.orderwaiting-update-product');

    // Sélecteurs des autres champs
    const unitySelect = document.querySelector('select[name="unity_id"]');
    const providerSelect = document.querySelector('select[name="provider_id"]');

    // Quand le produit change
    productSelect.addEventListener('change', () => {
        const selectedOption = productSelect.options[productSelect.selectedIndex];

        // Récupération des data-attributes
        const unityId = selectedOption.getAttribute('data-unity');
        const providerId = selectedOption.getAttribute('data-provider');

        // Mise à jour des selects
        if (unitySelect && unityId) {
            unitySelect.value = unityId;
        } else if (unitySelect) {
            unitySelect.value = ''; // reset si vide
        }

        if (providerSelect && providerId) {
            providerSelect.value = providerId;
        } else if (providerSelect) {
            providerSelect.value = '';
        }
    });
});



// ---------------------------------------------------------------------------------
// ------------------------------------ QUILL --------------------------------------
// ---------------------------------------------------------------------------------
document.addEventListener("DOMContentLoaded", function () {
    const quillEditors = document.querySelectorAll(".quill-editor");

    quillEditors.forEach((editorEl) => {
        // Initialise Quill
        const quill = new Quill(editorEl, {
            theme: 'snow'
        });

        // Trouve le champ hidden
        const hiddenInput = editorEl.parentElement.querySelector('input[name="email_content"]');
        if (!hiddenInput) return;

        // 🔹 Précharge le hidden avec le contenu HTML déjà présent dans Quill
        hiddenInput.value = quill.root.innerHTML;

        // 🔹 Synchronise le hidden dès qu’on modifie le texte
        quill.on('text-change', function () {
            hiddenInput.value = quill.root.innerHTML;
        });
    });
});


// ---------------------------------------------------------------------------------
// ---------------------------------- NAV TABS -------------------------------------
// ---------------------------------------------------------------------------------
document.addEventListener("DOMContentLoaded", function () {
    const tabsContainer = document.querySelector(".nav-tabs");
    if (!tabsContainer) return;

    const tabLinks = tabsContainer.querySelectorAll("ul li a");
    const tabPanes = tabsContainer.querySelectorAll(".tab-pane");

    // Fonction pour activer un onglet
    function activateTab(tabId) {
        // Désactive tous les onglets
        tabLinks.forEach(link => {
            link.classList.remove("text-white", "bg-blue-700", "dark:bg-blue-600", "active");
            link.classList.add("bg-gray-50", "text-gray-500", "dark:bg-gray-800", "dark:text-gray-400");
        });

        // Cache tous les contenus
        tabPanes.forEach(pane => {
            pane.style.display = "none";
        });

        // Active le bon lien
        const activeLink = tabsContainer.querySelector(`a[href="${tabId}"]`);
        if (activeLink) {
            activeLink.classList.add("text-white", "bg-blue-700", "dark:bg-blue-600", "active");
            activeLink.classList.remove("bg-gray-50", "text-gray-500", "dark:bg-gray-800", "dark:text-gray-400");
        }

        // Affiche le bon contenu
        const activePane = tabsContainer.querySelector(tabId);
        if (activePane) {
            activePane.style.display = "block";
        }
    }

    // Écoute les clics sur les onglets
    tabLinks.forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault();

            const href = this.getAttribute("href");
            const isDisabled = this.classList.contains("cursor-not-allowed");
            if (isDisabled) return;

            activateTab(href);
        });
    });

    // Active le premier onglet par défaut
    const defaultTab = tabLinks[0]?.getAttribute("href");
    if (defaultTab) activateTab(defaultTab);
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
		updateSection('sectionOrderWaiting');
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
	var main = $('.main-wrapper');
	var responsiveMenu = $('.nav-mobile');

	main.toggleClass('open-menu');
	responsiveMenu.toggleClass('active');
});