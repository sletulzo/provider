<script>
    let deferredPrompt;

    const installBtn = document.getElementById('installPWA');

    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        installBtn.style.display = 'block';
    });

    window.addEventListener("appinstalled", () => {
        console.log("PWA installée");
        installBtn.style.display = 'none';
    });

    installBtn.addEventListener('click', async () => {
        if (!deferredPrompt) return;

        installBtn.style.display = 'none';

        deferredPrompt.prompt();
        const choice = await deferredPrompt.userChoice;

        if (choice.outcome === 'accepted') {
            console.log('Installation acceptée');
        } else {
            console.log('Installation refusée');
            installBtn.style.display = 'block';
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
</script>
