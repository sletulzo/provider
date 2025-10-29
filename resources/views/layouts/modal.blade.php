<div id="ajaxModal"
     class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50 hidden">
  <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 relative">
    <!-- Bouton de fermeture -->
    <button id="closeModalBtn" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 transition">
      ✕
    </button>

    <!-- Contenu dynamique -->
    <div id="ajaxModalContent" class="text-gray-500">
      <div class="flex items-center justify-center h-32">
        <svg class="animate-spin h-6 w-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8v8H4z"></path>
        </svg>
      </div>
    </div>
  </div>
</div>