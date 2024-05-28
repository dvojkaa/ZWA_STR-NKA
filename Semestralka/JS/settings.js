
let buttonStart = document.getElementById("start");
buttonStart.addEventListener("click", start);


if ('serviceWorker' in navigator) {
 window.addEventListener('load', function() {
     navigator.serviceWorker.register('../JS/service-worker.js')
         .then(function(registration) {
             console.log('ServiceWorker registration successful with scope: ', registration.scope);
         })
         .catch(function(err) {
             console.log('ServiceWorker registration failed: ', err);
         });
 });
}


window.addEventListener('offline', function() {
    document.getElementById('status').innerText = 'Status: Offline';
    console.log('Lost internet connection. Playing in offline mode.');
});

window.addEventListener('online', function() {
    document.getElementById('status').innerText = 'Status: Online';
    console.log('Internet connection restored. Playing in online mode.');
});

let game = new Game();





function toggleHowToPlay() {
    const howToPlay = document.getElementById('how-to-play');
    howToPlay.classList.toggle('active');
}

function start() {
    buttonStart.style.display = "none"
    game.startstart();
}

function end(game){

    buttonStart.style.display = "inline-table"
    let board = game.board;
    board.canvas.style.display = "none";
}