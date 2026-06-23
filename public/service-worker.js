self.addEventListener('install', event => {
  self.skipWaiting();
});

self.addEventListener('activate', event => {
  event.waitUntil(clients.claim());
});

// IMPORTANT : ne rien intercepter
self.addEventListener('fetch', event => {});

// Notifications Web Push
self.addEventListener('push', event => {
  let payload = {};

  try {
    payload = event.data ? event.data.json() : {};
  } catch (e) {
    payload = {
      title: 'Vinste',
      body: event.data ? event.data.text() : '',
    };
  }

  const title = payload.title || 'Vinste';
  const url = (payload.data && payload.data.url) || payload.url || '/';
  const options = {
    body: payload.body || '',
    icon: payload.icon || '/icons/logo-transparent.png',
    tag: payload.tag || undefined,
    data: {
      url: url,
    },
  };

  event.waitUntil(self.registration.showNotification(title, options));
});

self.addEventListener('notificationclick', event => {
  event.notification.close();

  const targetUrl = (event.notification.data && event.notification.data.url) || '/';

  event.waitUntil(
    clients.matchAll({ type: 'window', includeUncontrolled: true }).then(clientList => {
      for (const client of clientList) {
        if ('focus' in client) {
          client.navigate(targetUrl);
          return client.focus();
        }
      }

      if (clients.openWindow) {
        return clients.openWindow(targetUrl);
      }
    })
  );
});
