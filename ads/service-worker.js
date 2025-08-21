const CACHE_NAME = 'flashlearn-v1';
const ASSETS = [
	'/ads/app.php?route=login',
	'/ads/inline.css',
	'/ads/wizard.js',
	'/ads/manifest.webmanifest'
];

self.addEventListener('install', (event) => {
	event.waitUntil(caches.open(CACHE_NAME).then((cache) => cache.addAll(ASSETS)));
});

self.addEventListener('activate', (event) => {
	event.waitUntil(
		caches.keys().then(keys => Promise.all(keys.map(k => k !== CACHE_NAME ? caches.delete(k) : null)))
	);
});

self.addEventListener('fetch', (event) => {
	const { request } = event;
	event.respondWith(
		caches.match(request).then((cached) => {
			const fetchPromise = fetch(request).then((response) => {
				const copy = response.clone();
				caches.open(CACHE_NAME).then(cache => cache.put(request, copy));
				return response;
			});
			return cached || fetchPromise;
		})
	);
});


