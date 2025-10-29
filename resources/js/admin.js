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

// const quill = new Quill('.quill-editor', {
//     theme: 'snow'
// });


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

