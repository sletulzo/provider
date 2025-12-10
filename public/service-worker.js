self.addEventListener('install', event => {
  self.skipWaiting();
});

self.addEventListener('activate', event => {
  event.waitUntil(clients.claim());
});

// IMPORTANT : ne rien intercepter
self.addEventListener('fetch', event => {});