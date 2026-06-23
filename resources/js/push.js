// -----------------------------------------------------------------------
// Notifications Web Push (PWA)
// -----------------------------------------------------------------------

function meta(name) {
    const el = document.querySelector(`meta[name="${name}"]`);
    return el ? el.getAttribute('content') : null;
}

function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - (base64String.length % 4)) % 4);
    const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);
    for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}

function pushSupported() {
    return 'serviceWorker' in navigator && 'PushManager' in window && 'Notification' in window;
}

async function getRegistration() {
    return navigator.serviceWorker.register('/service-worker.js');
}

async function postJson(url, body) {
    const token = meta('csrf-token');
    const response = await fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            Accept: 'application/json',
        },
        body: JSON.stringify(body),
    });

    if (!response.ok) {
        throw new Error('Requête échouée : ' + response.status);
    }

    return response.json();
}

async function subscribe() {
    const publicKey = meta('vapid-public-key');
    if (!publicKey) {
        throw new Error('Clé VAPID manquante.');
    }

    const permission = await Notification.requestPermission();
    if (permission !== 'granted') {
        throw new Error('permission-denied');
    }

    const registration = await getRegistration();
    await navigator.serviceWorker.ready;

    let subscription = await registration.pushManager.getSubscription();
    if (!subscription) {
        subscription = await registration.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: urlBase64ToUint8Array(publicKey),
        });
    }

    const json = subscription.toJSON();
    await postJson(meta('push-subscribe-url'), {
        endpoint: subscription.endpoint,
        keys: json.keys,
        contentEncoding: (PushManager.supportedContentEncodings || ['aesgcm'])[0],
    });

    return subscription;
}

async function unsubscribe() {
    const registration = await getRegistration();
    const subscription = await registration.pushManager.getSubscription();

    if (subscription) {
        await postJson(meta('push-unsubscribe-url'), { endpoint: subscription.endpoint });
        await subscription.unsubscribe();
    }
}

function initPushCard() {
    const card = document.querySelector('[data-push-card]');
    if (!card) {
        return;
    }

    const statusEl = card.querySelector('[data-push-status]');
    const enableBtn = card.querySelector('[data-push-enable]');
    const disableBtn = card.querySelector('[data-push-disable]');

    const setState = (message, { showEnable = false, showDisable = false } = {}) => {
        if (statusEl) statusEl.textContent = message;
        if (enableBtn) enableBtn.hidden = !showEnable;
        if (disableBtn) disableBtn.hidden = !showDisable;
    };

    if (!pushSupported()) {
        setState("Cet appareil ou navigateur ne prend pas en charge les notifications. Sur iPhone, installez d'abord l'application sur l'écran d'accueil.");
        return;
    }

    if (Notification.permission === 'denied') {
        setState('Les notifications sont bloquées dans les réglages du navigateur. Autorisez-les pour cette application.');
        return;
    }

    (async () => {
        try {
            const registration = await getRegistration();
            const subscription = await registration.pushManager.getSubscription();
            if (subscription) {
                setState('Les notifications sont activées sur cet appareil.', { showDisable: true });
            } else {
                setState('Les notifications ne sont pas encore activées sur cet appareil.', { showEnable: true });
            }
        } catch (e) {
            setState('Impossible de vérifier l\'état des notifications.', { showEnable: true });
        }
    })();

    if (enableBtn) {
        enableBtn.addEventListener('click', async () => {
            enableBtn.disabled = true;
            try {
                await subscribe();
                setState('Les notifications sont activées sur cet appareil.', { showDisable: true });
                window.toastr && window.toastr.success('Notifications activées.');
            } catch (e) {
                if (e.message === 'permission-denied') {
                    setState('Permission refusée. Autorisez les notifications pour activer cette fonctionnalité.', { showEnable: true });
                } else {
                    setState('Échec de l\'activation des notifications.', { showEnable: true });
                    window.toastr && window.toastr.error('Échec de l\'activation des notifications.');
                }
            } finally {
                enableBtn.disabled = false;
            }
        });
    }

    if (disableBtn) {
        disableBtn.addEventListener('click', async () => {
            disableBtn.disabled = true;
            try {
                await unsubscribe();
                setState('Les notifications ne sont pas encore activées sur cet appareil.', { showEnable: true });
                window.toastr && window.toastr.info('Notifications désactivées.');
            } catch (e) {
                setState('Échec de la désactivation.', { showDisable: true });
            } finally {
                disableBtn.disabled = false;
            }
        });
    }
}

// Enregistre le service worker au chargement (nécessaire au push) et initialise la carte.
if (pushSupported()) {
    getRegistration().catch(() => {});
}

document.addEventListener('DOMContentLoaded', initPushCard);
document.addEventListener('livewire:navigated', initPushCard);
