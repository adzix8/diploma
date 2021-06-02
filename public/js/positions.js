const positions = document.getElementById('search_player_position');
const height = document.querySelector('.height');
const goals = document.querySelector('.goals');
const assists = document.querySelector('.assists');
const passes = document.querySelector('.passes');
const touches = document.querySelector('.touches');
const speed = document.querySelector('.speed');
const clearances = document.querySelector('.clearances');
const dualsWon = document.querySelector('.duals-won');
const dribbles = document.querySelector('.dribbles');
const crosses = document.querySelector('.crosses');
const chances = document.querySelector('.chances');
const errors = document.querySelector('.errors');
const shoots = document.querySelector('.shoots');
const saves = document.querySelector('.saves');
const penaltySaves = document.querySelector('.penalty-saves');
const goalsConceded = document.querySelector('.goals-conceded');
const cleanSheets = document.querySelector('.clean-sheets');

function addAndRemoveClasses(addList = [], removeList = []) {
    addList.forEach((el) => {
        el.classList.add('none');
    });
    removeList.forEach((el) => {
        el.classList.remove('none');
    });
}

function changePosition(value) {
    switch (value)
    {
        case '1':
            addAndRemoveClasses(
                [assists, goals, passes, speed, dualsWon, clearances, dribbles, crosses, touches, chances, shoots],
                [height, saves, penaltySaves, goalsConceded, cleanSheets, errors],
            );
            break;
        case '2':
            addAndRemoveClasses(
                [assists, saves, penaltySaves, goalsConceded, cleanSheets, dribbles, crosses, touches, chances, shoots],
                [height, goals, passes, speed, dualsWon, clearances, errors],
            );
            break;
        case '3':
            addAndRemoveClasses(
                [height, saves, penaltySaves, goalsConceded, cleanSheets, dribbles, touches, chances, shoots],
                [goals, assists, passes, speed, dualsWon, clearances, crosses, errors],
            );
            break;
        case '4':
            addAndRemoveClasses(
                [saves, penaltySaves, goalsConceded, cleanSheets, dribbles, errors, height, shoots],
                [goals, assists, passes, speed, dualsWon, clearances, touches, crosses, chances],
            );
            break;
        case '5':
            addAndRemoveClasses(
                [saves, penaltySaves, goalsConceded, cleanSheets, clearances, errors, height, shoots],
                [goals, assists, passes, speed, dualsWon, dribbles, touches, crosses, chances],
            );
            break;
        case '6':
            addAndRemoveClasses(
                [saves, penaltySaves, goalsConceded, cleanSheets, clearances, errors, height, crosses, dribbles],
                [goals, assists, passes, speed, dualsWon, touches, chances, height, shoots],
            );
            break;
    }
}

positions.addEventListener('change', (event) =>
{
    changePosition(event.target.value);
});


window.onload = function () {
    changePosition(positions.value);
};
