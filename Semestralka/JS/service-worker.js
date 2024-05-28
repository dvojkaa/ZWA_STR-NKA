const cacheName = 'dino-game-cache-v1';
const filesToCache = [
    '../HTML/index.html',
    '../HTML/DB.php',
    '../HTML/dino.php',
    '../HTML/score.php',
    '../CSS/stylesheet.css',
    '../CSS/score.css',
    '../CSS/dino.css',
    '../JS/settings.js',
    '../JS/dinoOOP.js',
    '../JS/service-worker.js',
    '../JS/score.js',
    '../img/dino.png',
    '../img/big-cactus1.png',
    '../img/big-cactus2.png',
    '../img/big-cactus3.png',
    '../img/dino-run1.png',
    '../img/dino-run2.png',
    '../img/dino-duck1.png',
    '../img/dino-duck2.png',
    '../img/cactus1.png',
    '../img/cactus2.png',
    '../img/cactus3.png',
    '../img/bird1.png',
    '../img/bird2.png',
    '../img/cloud.png',
    '../img/dino-dead.png',
    '../img/game-over.png',
    '../img/reset.png',
    '../img/track.png',
    '../music/Background_music.mp3',
    '../music/jump.mp3',
    '../music/Death.mp3',
];


self.addEventListener('install', function(event) {
    event.waitUntil(
        caches.open(cacheName)
            .then(function(cache) {
                return cache.addAll(filesToCache);
            })
    );
});

self.addEventListener('fetch', function(event) {
    event.respondWith(
        caches.match(event.request)
            .then(function(response) {
                if (response) {
                    return response;
                }
                return fetch(event.request);
            })
    );
});
