<script>
document.addEventListener("DOMContentLoaded", () => {

    let deferredPrompt;

    const installBtn = document.getElementById('installPWA');

    if (!installBtn) return; // sécurité

    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        installBtn.style.display = 'flex';
    });

    window.addEventListener("appinstalled", () => {
        installBtn.style.display = 'none';
    });

    installBtn.addEventListener('click', async () => {
        if (!deferredPrompt) return;

        installBtn.style.display = 'none';

        deferredPrompt.prompt();
        const choice = await deferredPrompt.userChoice;

        if (choice.outcome !== 'accepted') {
            installBtn.style.display = 'flex';
        }

        deferredPrompt = null;
    });

    function isStandalone() {
        return window.matchMedia('(display-mode: standalone)').matches ||
               window.navigator.standalone === true;
    }

    if (isStandalone()) {
        installBtn.style.display = 'none';
    }

});
</script>