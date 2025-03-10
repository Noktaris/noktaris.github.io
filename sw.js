const CACHE_NAME = 'noktaris-v1';
const urlsToCache = [
  '/',
  '/index.html',
  '/index.css',
  '/images/bebce75f-a4d3-4d00-9b51-bc9f978c9c4a-profile_image-300x300.png'
];

self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => cache.addAll(urlsToCache))
  );
});

self.addEventListener('fetch', event => {
  event.respondWith(
    caches.match(event.request)
      .then(response => response || fetch(event.request))
  );
});
  