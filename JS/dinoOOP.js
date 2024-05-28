
// manifest json nemam




// Nastavení rychlosti objektů a gravitace
let highScore = sessionStorage.getItem("highScore") || 0;

// physics
let objectsVelocityX = 0;
let cloudVelocityX = -8;
let gravitySetter = 1;
let gravity = gravitySetter;

let dinoY;

let score = 0;
let timerObstical = 0;
let timerAnime = 0;

let gameOver = false;
let gameOverImg;
let cloudImg;
let dinoImg;
let dinoImgRun1;
let dinoImgRun2;
let dinoImgDuck1;
let dinoImgDuck2;
let currentImage = 1;

let cactus1Width = 34;
let cactus2Width = 69;
let cactus3Width = 102;

let cactus1Img;
let cactus2Img;
let cactus3Img;
let bird1;
let bird2;
let landImg;
let landx = 0;


// Třída Board pro vykreslovací plochu
class Board {
    constructor() {
        this.width = 750;
        this.height = 250;
        this.canvas = document.getElementById("board");
        this.canvas.width = this.width;
        this.canvas.height = this.height;
        this.context = this.canvas.getContext("2d");
    }


    // Metoda pro vyčištění plochy
    clear() {
        this.context.clearRect(0, 0, this.width, this.height);
    }
}


// Třída Dino pro dinosaura
class Dino {
    constructor(x, y, width, height) {
        this.x = x;
        this.y = y;
        this.width = width;
        this.height = height;
        this.duck = false;
        this.velocityX = 0;
        this.velocityY = 0;
    }
}


// Třída Cactus pro překážky
class Cactus {
    constructor(x, y, width, height, velocity, img, name) {
        this.x = x;
        this.y = y;
        this.width = width;
        this.height = height;
        this.velocity = velocity;
        this.img = img;
        this.name = name;
    }
}


// Třída Bird pro ptáky
class Bird {
    constructor(x, y, width, height, velocity, img, img2, name) {
        this.x = x;
        this.y = y;
        this.width = width;
        this.height = height;
        this.velocity = velocity;
        this.img = img;
        this.img2 = img2;
        this.name = name;
    }
}


// Třída Cloud pro mraky
class Cloud {
    constructor(x, y, width, height, velocity, img) {
        this.x = x;
        this.y = y;
        this.width = width;
        this.height = height;
        this.velocity = velocity;
        this.img = img;
    }
}



// Třída MusicPlayer pro přehrávání zvuků
class MusicPlayer {
    constructor() {
        this.audioContext = new (window.AudioContext || window.webkitAudioContext)();
        this.buffers = {};
    }


    // Metoda pro načtení zvuku
    async loadSound(url, name) {
        const response = await fetch(url);
        const arrayBuffer = await response.arrayBuffer();
        const audioBuffer = await this.audioContext.decodeAudioData(arrayBuffer);
        this.buffers[name] = audioBuffer;
    }


    // Metoda pro přehrání zvuku
    playSound(name, loop = false) {
        if (!this.buffers[name]) {
            console.error(`Sound ${name} not loaded.`);
            return;
        }
        const source = this.audioContext.createBufferSource();
        source.buffer = this.buffers[name];
        source.loop = loop;
        source.connect(this.audioContext.destination);
        source.start(0);
    }


    // Metoda pro zastavení zvuku
    stopSound(name) {
        if (!this.buffers[name]) {
            console.error(`Sound ${name} not loaded.`);
            return;
        }
        const source = this.audioContext.createBufferSource();
        source.buffer = this.buffers[name];
        source.connect(this.audioContext.destination);
        source.stop(0);
    }


    // Metoda pro obnovení audio kontextu, pokud je pozastavený
    async resumeAudioContext() {
        if (this.audioContext.state === 'suspended') {
            await this.audioContext.resume();
        }
    }
}


// Třída Game pro hlavní herní logiku
class Game {
    constructor() {
        this.board = new Board();
        this.dino = new Dino(50, this.board.height - 94, 88, 94);
        this.objects = [];
        this.clouds = [];
        this.controler = new Controller(this);
        this.musicPlayer = new MusicPlayer();
    }


    // Asynchronní metoda pro spuštění hry s načtením zvuků
    async startstart(){
        this.board.canvas.style.display = "inline-table";
        await this.musicPlayer.resumeAudioContext();
        await this.musicPlayer.loadSound('../music/Background_music.mp3', 'background');
        await this.musicPlayer.loadSound('../music/jump.mp3', 'jump');
        await this.musicPlayer.loadSound('../music/Death.mp3', 'crash');
        this.musicPlayer.playSound('background', true);
        this.start()
    }

    // Metoda pro spuštění hry
    start() {

        dinoY = this.board.height - this.dino.height;
        gameOverImg = new Image();
        gameOverImg.src = "../img/game-over.png";
        cloudImg = new Image();
        cloudImg.src = "../img/cloud.png";

        dinoImg = new Image();
        dinoImg.src = "../img/dino.png";
        dinoImg.onload = () => {
            this.board.context.drawImage(dinoImg, this.dino.x, this.dino.y, this.dino.width, this.dino.height);
        };

        landImg = new Image();
        landImg.src = "../img/track.png";

        dinoImgRun1 = new Image();
        dinoImgRun1.src = "../img/dino-run1.png";
        dinoImgRun2 = new Image();
        dinoImgRun2.src = "../img/dino-run2.png";
        dinoImgDuck1 = new Image();
        dinoImgDuck1.src = "../img/dino-duck1.png";
        dinoImgDuck2 = new Image();
        dinoImgDuck2.src = "../img/dino-duck2.png";

        cactus1Img = new Image();
        cactus1Img.src = "../img/cactus1.png";

        cactus2Img = new Image();
        cactus2Img.src = "../img/cactus2.png";

        cactus3Img = new Image();
        cactus3Img.src = "../img/cactus3.png";

        bird1 = new Image();
        bird1.src = "../img/bird1.png";

        bird2 = new Image();
        bird2.src = "../img/bird2.png";

        this.updateLoop = this.updateLoop.bind(this);
        this.updateLoop();
    }


    // Hlavní herní smyčka pro aktualizaci stavu hry
    updateLoop() {
        if (!gameOver) {
            this.update();
            requestAnimationFrame(this.updateLoop);
            document.addEventListener("keydown", this.controler.keyControlerDown.bind(this.controler));
            document.addEventListener("keyup", this.controler.keyControlerUp.bind(this.controler));
            this.board.canvas.addEventListener('click', this.controler.mouseControler.bind(this.controler));
        }
    }

    // Aktualizace stavu hry
    update() {
        timerObstical += 1;
        timerAnime += 1;
        if (timerObstical === 50) {
            this.placeObstical();
            timerObstical = 0;
            objectsVelocityX -= 0.5;
            cloudVelocityX -= 0.5;
        }

        if (timerAnime === 5) {
            timerAnime = 0;
            currentImage = 1 - currentImage;
        }

        if (gameOver) {
            this.resetGame();
            return;
        }

        this.board.clear();

        landx += cloudVelocityX;
        if (landx <= -(2404 - 760)) {
            landx = 0;
        }

        this.board.context.drawImage(landImg, landx, this.board.height - 30, 2404, 28);

        this.dino.velocityY += gravity;
        this.dino.y = Math.min(this.dino.y + this.dino.velocityY, dinoY);
        this.dino.x = Math.max(this.dino.x + this.dino.velocityX, 0);
        if (this.dino.x > this.board.width - this.dino.width) {
            this.dino.x = this.board.width - this.dino.width;
        }

        if (this.dino.duck) {
            this.dino.width = 118;
            this.dino.height = 60;
            this.dino.y = this.board.height - this.dino.height;
            if (currentImage === 1) {
                this.board.context.drawImage(dinoImgDuck1, this.dino.x, this.dino.y, this.dino.width, this.dino.height);
            } else {
                this.board.context.drawImage(dinoImgDuck2, this.dino.x, this.dino.y, this.dino.width, this.dino.height);
            }
        } else {
            this.dino.width = 88;
            this.dino.height = 94;
            if (currentImage === 1) {
                this.board.context.drawImage(dinoImgRun1, this.dino.x, this.dino.y, this.dino.width, this.dino.height);
            } else {
                this.board.context.drawImage(dinoImgRun2, this.dino.x, this.dino.y, this.dino.width, this.dino.height);
            }
        }

        this.objects.forEach(cactus => {
            cactus.x += cactus.velocity + objectsVelocityX;
            if (cactus.name === "bird") {
                if (currentImage === 1) {
                    this.board.context.drawImage(cactus.img, cactus.x, cactus.y, cactus.width, cactus.height);
                } else {
                    this.board.context.drawImage(cactus.img2, cactus.x, cactus.y, cactus.width, cactus.height);
                }
            } else {
                this.board.context.drawImage(cactus.img, cactus.x, cactus.y, cactus.width, cactus.height);
            }
            if (this.detectCollision(this.dino, cactus)) {
                this.musicPlayer.playSound('crash');
                this.board.clear();
                gameOver = true;
                dinoImg.src = "../img/dino-dead.png";
                dinoImg.onload = () => {
                    this.board.context.drawImage(dinoImg, this.dino.x, this.dino.y, this.dino.width, this.dino.height);
                };
                this.resetGame();
            }
        });

        this.clouds.forEach(cloud => {
            cloud.x += cloud.velocity;
            this.board.context.drawImage(cloudImg, cloud.x, cloud.y, cloud.width, cloud.height);
        });

        this.board.context.fillStyle = "black";
        this.board.context.font = "20px courier";
        score++;
        this.board.context.fillText(score, 5, 40);
        this.board.context.fillText("HI " + highScore, 5, 20);
    }

    // Funkce pro resetování hry po game over
    resetGame() {
        if (score > highScore) {
            highScore = score;
            sessionStorage.setItem("highScore", highScore);
        }
        score = 0;
        objectsVelocityX = 0;
        cloudVelocityX = -8;
        this.dino.velocityY = 0;
        gravity = gravitySetter;
        this.board.clear();
        this.objects = [];
        this.clouds = [];
        this.dino.x = 50;
        this.dino.y = this.board.height - this.dino.height;
        landx = 0;

        this.board.context.drawImage(gameOverImg, this.board.width / 2 - 386 / 2, this.board.height / 2 - 20, 386, 40);
        let resetImg = new Image();
        resetImg.src = "../img/reset.png";
        this.board.context.drawImage(resetImg, this.board.width / 2 - 76 / 2, this.board.height / 2 + 10, 76, 68);
        this.start();
    }


    // Funkce pro umístění nové překážky
    placeObstical() {
        if (gameOver) {
            this.resetGame();
            return;
        }
        let cactus = new Cactus(700, this.board.height - 70, null, 70, -8, null, "cactus");

        let bird = new Bird(700, 120, 97, 62, -8, bird1, bird2, "bird");

        let placeCactusChance = Math.random();

        let cloud = new Cloud(700, 40 + (placeCactusChance * 10), 84, 101, -5, cloudImg);

        if (placeCactusChance > 0.90) {
            cactus.img = cactus3Img;
            cactus.width = cactus3Width;
            this.objects.push(cactus);
        } else if (placeCactusChance > 0.70) {
            cactus.img = cactus2Img;
            cactus.width = cactus2Width;
            this.objects.push(cactus);
        } else if (placeCactusChance > 0.50) {
            cactus.img = cactus1Img;
            cactus.width = cactus1Width;
            this.objects.push(cactus);
        } else if (placeCactusChance > 0.30) {
            this.objects.push(bird);
        }

        if (this.objects.length > 5) {
            this.objects.shift();
        }

        if (this.clouds.length > 3) {
            this.clouds.shift();
        } else {
            this.clouds.push(cloud);
        }
    }

    // Funkce pro kontrolu kolizí
    detectCollision(a, b) {
        return a.x < b.x + b.width &&
            a.x + a.width > b.x &&
            a.y < b.y + b.height &&
            a.y + a.height > b.y;
    }
}

// Třída Controller pro ovládání hry
class Controller {
    constructor(game) {
        this.game = game;
        this.dino = this.game.dino;
    }

    // Metoda pro zpracování uvolnění klávesy
    keyControlerUp(e) {
        gravity = gravitySetter;

        if (e.code === "ArrowDown" || e.code === "KeyS") {
            this.dino.duck = false;
        } else if ((e.code === "Space" || e.code === "ArrowUp" || e.code === "KeyW") && this.dino.y === dinoY) {
            gravity = gravitySetter;
        } else if ((e.code === "ArrowLeft" || e.code === "KeyA") || (e.code === "ArrowRight" || e.code === "KeyD")) {
            this.dino.velocityX = 0;
        }
    }


    // Metoda pro zpracování stisknutí klávesy
    keyControlerDown(e) {
        if (e.code === "KeyR") {
            this.game.resetGame();


        } else if ((e.code === "Space" || e.code === "ArrowUp" || e.code === "KeyW") && this.dino.y === dinoY) {
            if (!gameOver) {
                this.game.musicPlayer.playSound('jump');
            }
            this.dino.velocityY = -20;
            gravity = 0.8;
        } else if (e.code === "ArrowDown" || e.code === "KeyS") {
            if (this.dino.y === dinoY) {
                this.dino.duck = true;
            }
            gravity = gravitySetter + 1;
        } else if (e.code === "ArrowLeft" || e.code === "KeyA") {
            this.dino.velocityX = -5;
        } else if (e.code === "ArrowRight" || e.code === "KeyD") {
            this.dino.velocityX = 5;
        } else if (e.code === "Enter" && !gameOver) {
            gameOver = false;
            this.game.musicPlayer.stopSound('background');
            end(this.game);

        }
    }



    // Metoda pro zpracování kliknutí myši
    mouseControler(event) {
        const rect = this.game.board.canvas.getBoundingClientRect();
        const mouseX = event.clientX - rect.left;
        const mouseY = event.clientY - rect.top;

        if (
            mouseX >= this.game.board.width / 2 - 76 / 2 &&
            mouseX <= this.game.board.width / 2 - 76 / 2 + 76 &&
            mouseY >= this.game.board.height / 2 + 10 &&
            mouseY <= this.game.board.height / 2 + 10 + 68 &&
            gameOver
        ) {
            console.log('Reset button clicked!');
            gameOver = false;
            this.game.resetGame();
        }
    }
}
