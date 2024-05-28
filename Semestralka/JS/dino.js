//
// //board
// let board;
// let boardWidth = 750;
// let boardHeight = 250;
// let context;
// let gameOverImg;
//
// let cloudImg;
// let cloudArray = [];
// let menu = false;
//
//
// //dino
// let dinoWidth = 88;
// let dinoHeight = 94;
// let dinoX = 50;
// let dinoY = boardHeight - dinoHeight;
// let dinoImg;
// let dinoImgRun1;
// let dinoImgRun2;
// let dinoImgDuck1;
// let dinoImgDuck2;
// let duck = false;
// let currentImage = 1
// let highScore = sessionStorage.getItem("highScore") || 0;
//
// // let dino = {
// //     x : dinoX,
// //     y : dinoY,
// //     width : dinoWidth,
// //     height : dinoHeight
// // }
//
// //cactus
// let cactusArray = [];
//
// let cactus1Width = 34;
// let cactus2Width = 69;
// let cactus3Width = 102;
// let birdWidth = 97;
//
// let birdHeight = 62;
// let birdX = 700;
// let birdY = 120;
//
// let cactusHeight = 70;
// let cactusX = 700;
// let cactusY = boardHeight - cactusHeight;
//
// let cactus1Img;
// let cactus2Img;
// let cactus3Img;
// let bird1;
// let bird2;
//
// //physics
// let objectsVelocityX = -8;
// let velocityX = 0;//cactus moving left speed
// let velocityY = 0;
// let gravitySetter = 1;
// let gravity = gravitySetter;
//
// let gameOver = false;
// let score = 0;
// let timerObstical = 0;
// let timerAnime = 0;
// let diff = 1;
// let landImg ;
// let landx = 0;
//
//
//
// function gameLoop() {
//
//     board = document.getElementById("board");
//     board.style.display = "inline-table"
//     board.height = boardHeight;
//     board.width = boardWidth;
//
//     context = board.getContext("2d");
//
//     gameOverImg = new Image();
//     gameOverImg.src = "../img/game-over.png"
//     cloudImg = new Image();
//     cloudImg.src = "../img/cloud.png"
//
//     dinoImg = new Image();
//     dinoImg.src = "../img/dino.png";
//     dinoImg.onload = function() {
//         context.drawImage(dinoImg, dino.x, dino.y, dino.width, dino.height);
//     }
//
//
//     landImg = new Image();
//     landImg.src = "../img/track.png";
//
//
//     dinoImgRun1 = new Image();
//     dinoImgRun1.src = "../img/dino-run1.png";
//     dinoImgRun2 = new Image();
//     dinoImgRun2.src = "../img/dino-run2.png";
//     dinoImgDuck1 = new Image();
//     dinoImgDuck1.src = "../img/dino-duck1.png";
//     dinoImgDuck2 = new Image();
//     dinoImgDuck2.src = "../img/dino-duck2.png";
//
//     cactus1Img = new Image();
//     cactus1Img.src = "../img/cactus1.png";
//
//     cactus2Img = new Image();
//     cactus2Img.src = "../img/cactus2.png";
//
//     cactus3Img = new Image();
//     cactus3Img.src = "../img/cactus3.png";
//
//     bird1 = new Image();
//     bird1.src = "../img/bird1.png";
//
//     bird2 = new Image();
//     bird2.src = "../img/bird2.png";
//
//     // Call update function repeatedly
//     function updateLoop() {
//         if (!gameOver) {
//             update();
//             requestAnimationFrame(updateLoop);
//             //setInterval(placeObstical, 20000)
//             document.addEventListener("keydown", keyControlerDown);
//             document.addEventListener("keyup", keyControlerUp);
//             board.addEventListener('click', mouseControler)
//         }
//     }
//     updateLoop();
// }
//
// function update() {
//     timerObstical += 1;
//     timerAnime += 1;
//     if (timerObstical === 50) {
//         placeObstical();
//         timerObstical = 0;
//         objectsVelocityX -= 0.5
//     }
//
//     if (timerAnime === 5) {
//         timerAnime = 0;
//         if (currentImage === 0){
//             currentImage = 1;
//         }else{
//             currentImage = 0;
//         }
//     }
//     if (gameOver) {
//         resetGame()
//         return;
//     }
//     context.clearRect(0,0,750,250)
//
//     landx += objectsVelocityX
//     if (landx <= -(2404 - 760)){
//         landx = 0;
//     }
//
//     context.drawImage(landImg, landx, boardHeight - 30, 2404, 28);
//     //dino
//     velocityY += gravity;
//     dino.y = Math.min(dino.y + velocityY, dinoY); //apply gravity to current dino.y, making sure it doesn't exceed the ground
//     dino.x = Math.max(dino.x + velocityX, 0);
//     if (dino.x > boardWidth - dinoWidth){
//         dino.x = boardWidth - dinoWidth;
//     }
//
//     if(duck) {
//         dino.width = 118;
//         dino.height = 60;
//
//         dino.y = boardHeight - dino.height;
//
//
//         if (currentImage === 1) {
//             context.drawImage(dinoImgDuck1, dino.x, dino.y, dino.width, dino.height);
//         } else {
//             context.drawImage(dinoImgDuck2, dino.x, dino.y, dino.width, dino.height);
//         }
//     }
//     else{
//         dino.width = 88;
//         dino.height = 94;
//         if (currentImage === 1) {
//             context.drawImage(dinoImgRun1, dino.x, dino.y, dino.width, dino.height);
//         } else {
//             context.drawImage(dinoImgRun2, dino.x, dino.y, dino.width, dino.height);
//         }
//     }
//
//     //context.drawImage(dinoImg, dino.x, dino.y, dino.width, dino.height);
//
//     //cactus
//     for (let i = 0; i < cactusArray.length; i++) {
//         let cactus = cactusArray[i];
//         cactus.x += objectsVelocityX;
//         if (cactus.name === "bird"){
//             if (currentImage === 1) {
//                 context.drawImage(cactus.img, cactus.x, cactus.y, cactus.width, cactus.height);
//             }else{
//                 context.drawImage(cactus.img2, cactus.x, cactus.y, cactus.width, cactus.height);
//
//             }
//         }else {
//             context.drawImage(cactus.img, cactus.x, cactus.y, cactus.width, cactus.height);
//         }
//         if (detectCollision(dino, cactus)) {
//             context.clearRect(0,0,boardWidth,boardHeight)
//             gameOver = true;
//             dinoImg.src = "../img/dino-dead.png";
//             dinoImg.onload = function() {
//                 context.drawImage(dinoImg, dino.x, dino.y, dino.width, dino.height);
//             }
//             resetGame();
//         }
//     }
//
//     for (let i = 0; i < cloudArray.length; i++) {
//         let cloud = cloudArray[i];
//         cloud.x += cloud.velocity;
//         context.drawImage(cloudImg, cloud.x, cloud.y, cloud.width, cloud.height);
//
//     }
//
//     //score
//     context.fillStyle="black";
//     context.font="20px courier";
//     score++;
//     context.fillText(score, 5, 40);
//     context.fillText("HI " + highScore, 5, 20);
//     context.fillText("Diff " + diff, boardWidth - 100, 20);
// }
//
// function keyControlerUp(e){
//     gravity = gravitySetter
//
//     if ((e.code === "ArrowDown" || e.code ==="KeyS")) {
//         duck = false;
//
//     }
//
//     else   if ((e.code === "Space" || e.code === "ArrowUp" || e.code ==="KeyW") && dino.y === dinoY) {
//         gravity = gravitySetter
//     }
//     else if  ((e.code === "ArrowLeft" || e.code === "KeyA")||(e.code === "ArrowRight" || e.code === "KeyD")){
//         velocityX = 0;
//     }
//
// }
// function keyControlerDown(e) {
//
//     if (e.code === "KeyR"){
//         if(gameOver){
//             gameOver = false;
//             end();
//             start();
//         }
//         resetGame();
//     }
//     else if ((e.code === "Space" || e.code === "ArrowUp" || e.code ==="KeyW") && dino.y === dinoY) {
//         //jump
//         velocityY = -20;
//         gravity = .8
//
//     }
//     else if (e.code === "ArrowDown" || e.code ==="KeyS") {
//         if (dino.y === dinoY) {
//             duck = true;
//         }
//         gravity = gravitySetter + 1
//     }
//     else if (e.code === "ArrowLeft" || e.code === "KeyA"){
//         velocityX = -5;
//     }
//     else if (e.code === "ArrowRight" || e.code === "KeyD"){
//         velocityX = 5;
//     }
//     else if (e.code ==="Enter" && !gameOver){
//         gameOver = false;
//         diff += 1;
//         end();
//         start();
//     }
//
// }
//
// function mouseControler(event) {
//     // Získání pozice kliknutí relativně k canvasu
//     const rect = board.getBoundingClientRect();
//     const mouseX = event.clientX - rect.left;
//     const mouseY = event.clientY - rect.top;
//
//     // Ověření, zda bylo kliknuto na obrázek resetu
//     if (
//         mouseX >= boardWidth / 2 - (76 / 2) &&
//         mouseX <= boardWidth / 2 - (76 / 2) + 76 &&
//         mouseY >= boardHeight / 2 + 10 &&
//         mouseY <= boardHeight / 2 + 10 + 68
//         && gameOver
//     ) {
//
//         console.log('Reset button clicked!');
//         gameOver = false;
//         end();
//         start();
//     }
// }
//
// function resetGame(){
//     if (score > highScore){
//         highScore = score;
//         sessionStorage.setItem("highScore", highScore);
//     }
//     score = 0;
//     objectsVelocityX = -8; //cactus moving left speed
//     velocityY = 0;
//     gravity = gravitySetter;
//     context.clearRect(0, 0, 750, 250);
//     cactusArray = [];
//     dino.x = 50;
//     dino.y = boardHeight - dinoHeight;
//     diff = 1;
//     landx = 0;
//
//     context.drawImage(gameOverImg, boardWidth/2 - 386/2, boardHeight/2 - 20, 386, 40);
//     let resetImg = new Image();
//     resetImg.src = "../img/reset.png";
//     context.drawImage(resetImg, boardWidth/2 - (76/2), boardHeight/2  + 10, 76, 68);
//
// }
//
// function placeObstical() {
//     if (gameOver) {
//         resetGame();
//         return;
//     }
//
//     //place cactus
//     let cactus = {
//         name: "cactus",
//         img : null,
//         img2: null,
//         x : cactusX,
//         y : cactusY,
//         width : null,
//         height: cactusHeight
//     }
//     let bird ={
//         name:"bird",
//         img : null,
//         img2: null,
//         x : birdX,
//         y : birdY,
//         width : null,
//         height: birdHeight
//     }
//
//
//
//     let placeCactusChance = Math.random(); //0 - 0.9999...
//
//     let cloud = {
//         velocity: -5,
//         x: 700,
//         y: 40 + (placeCactusChance*10),
//         width : 84,
//         height : 101
//
//     }
//
//
//     if (placeCactusChance > .90) {
//         cactus.img = cactus3Img;
//         cactus.img2 = cactus.img;
//         cactus.width = cactus3Width;
//         cactusArray.push(cactus);
//     }
//     else if (placeCactusChance > .70) {
//         cactus.img = cactus2Img;
//         cactus.img2 = cactus.img;
//         cactus.width = cactus2Width;
//         cactusArray.push(cactus);
//     }
//     else if (placeCactusChance > .50) {
//         cactus.img = cactus1Img;
//         cactus.img2 = cactus1Img;
//         cactus.width = cactus1Width;
//         cactusArray.push(cactus);
//     }
//     else if (placeCactusChance > .30) {
//         bird.img = bird1;
//         bird.img2 = bird2;
//         bird.width = birdWidth;
//         cactusArray.push(bird);
//     }
//
//     if (cactusArray.length > 5) {
//         cactusArray.shift();
//     }
//
//     if (cloudArray.length > 3){
//         cloudArray.shift();
//     }else{
//         cloudArray.push(cloud)
//     }
// }
//
// function detectCollision(a, b) {
//     return a.x < b.x + b.width &&
//         a.x + a.width > b.x &&
//         a.y < b.y + b.height &&
//         a.y + a.height > b.y;
// }
