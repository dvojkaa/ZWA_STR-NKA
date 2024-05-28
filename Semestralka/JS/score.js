

showLeaderboard();
document.getElementById('nameForm').addEventListener('submit', function(event) {

    document.getElementById("highScore").value = sessionStorage.getItem("highScore").valueOf()
});




function showLeaderboard() {

    fetch('../data/leaderboardList.json')
        .then(response => response.json())
        .then(data => {

            data.sort((a, b) => b.highScore - a.highScore);

            let leaderboardList = document.getElementById('leaderboardList');

            leaderboardList.innerHTML = '';

            data.forEach(player => {
                let listItem = document.createElement('li');
                listItem.textContent = `${player.playerName}: ${player.highScore}`;
                leaderboardList.appendChild(listItem);
            });
        })
        .catch(error => console.error('Error loading leaderboard data:', error));
}


document.addEventListener('DOMContentLoaded', showLeaderboard);

