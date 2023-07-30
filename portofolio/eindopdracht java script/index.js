let rollCount = 3;
let totalRounds = 12;
let totalScore = 0;
let heldDice = [false, false, false, false, false];
let diceArray = [1, 2, 3, 4, 5];

let p1Turn = true;
let p1Score = [];
let p1ScoreTemp = [];
let p2Score = [];
let p2ScoreTemp = [];

initGame();
let scores = [80, 70, 90, 85, 95]; // sample array of scores

function rollDice() {
  return Math.floor(Math.random() * 6) + 1;
}

function dice() {
  if (totalRounds <= 0) {
    document.getElementById("rounds-left").textContent = 0;
    document.querySelector(".button").setAttribute("disabled", "disabled");
    return;
  }

  if (rollCount > 0) {
    const images = document.querySelectorAll(".dice-container img");
    for (let i = 0; i < images.length; i++) {
      if (!heldDice[i]) {
        let diceResult = rollDice();
        images[i].setAttribute("src", `dice-${diceResult}.png`);
        diceArray[i] = diceResult;
      }
    }
  }
  rollCount--;

  if (p1Turn) {
    //initialize variables
    let i = 0;
    let j = 0;
    let nextCount;

    let lowerScore = checkSingles();
    nextCount = i + lowerScore.length;

    //add ones, twos, threes, etc. into array

    for (j = 0; i < nextCount; i++) {
      p1ScoreTemp[i] = lowerScore[j];
      j++;
    }

    i++; //skip 1 item for the bonus

    let threeOrFourOfAKind = ofAKind();
    nextCount = i + 3;

    //add 3 and 4 of a kind and Full House to array, skips yahtzee
    for (j = 0; i < nextCount; i++) {
      p1ScoreTemp[i] = threeOrFourOfAKind[j];
      j++;
    }

    let straightsScore = straights();
    nextCount = i + straightsScore.length;

    for (j = 0; i < nextCount; i++) {
      p1ScoreTemp[i] = straightsScore[j];
      j++;
    }

    p1ScoreTemp[i] = totalValue(diceArray);
    i++;
    p1ScoreTemp[i] = ofAKind()[3];
  }

  displayScores(p1Scoreboard, p1ScoreTemp, p1Score);

  if (rollCount < 1 && totalRounds > 1) {
    document.getElementById("rollButton").textContent = "Start Next Round";
  }
  document.getElementById("roll-count").textContent = rollCount;
  if (rollCount < 0) {
    let num = highestPointsReverse(p1ScoreTemp, p1Score);
    p1Score[num] = p1ScoreTemp[num];

    nextRolls();
    // updateScores();
  }
}
function displayScores(scoreboard, scores, fixedScores) {
  for (let i = 0; i < scoreboard.length; i++) {
    let value = 0;

    value = scores[i];
    if (fixedScores[i] !== 0) value = fixedScores[i];

    scoreboard[i].textContent = value;
  }
}
function highestPointsReverse(numberArray, numberArray2) {
  let highestNumberIndex = numberArray.length - 1;

  for (let i = numberArray.length - 1; i > -1; i--) {
    if (
      numberArray[i] > numberArray[highestNumberIndex] &&
      numberArray2[i] === 0
    )
      highestNumberIndex = i;
  }
  return highestNumberIndex;
}

function holdDice(diceNumber) {
  const image = document.getElementById(`dice${diceNumber}`);
  if (image.classList.contains("selected")) {
    heldDice[diceNumber - 1] = false;
    image.classList.remove("selected");
  } else {
    heldDice[diceNumber - 1] = true;
    image.classList.add("selected");
  }
}

function resetGame() {
  rollCount = 3;
  totalRounds = 12;
  totalScore = 0;
  heldDice = [false, false, false, false, false];
  p1Score = fillArray(0, 20);
  p2Score = fillArray(0, 20);
  p1ScoreTemp = fillArray(0, 20);
  p2ScoreTemp = fillArray(0, 20);

  const images = document.querySelectorAll(".dice-container img");
  for (let i = 0; i < images.length; i++) {
    images[i].classList.remove("selected");
    images[i].setAttribute("src", "dd.png");
  }
  document.getElementById("roll-count").textContent = rollCount;
  document.querySelector(".button").removeAttribute("disabled");
  document.getElementById("rounds-left").textContent = totalRounds + 1;

  displayScores(p1Scoreboard, p1ScoreTemp, p1Score);
  totalScore = 0;
  document.getElementById("p1-total-score").textContent = totalScore;
  initGame();
}

function nextRolls() {
  rollCount = 3;
  totalRounds--;
  heldDice = [false, false, false, false, false];
  p1ScoreTemp = fillArray(0, 20);
  p2ScoreTemp = fillArray(0, 20);

  document.getElementById("roll-count").textContent = rollCount;
  document.getElementById("rollButton").textContent = "Roll Dice!";

  for (let i = 0; i < 5; i++) {
    const image = document.getElementById(`dice${i + 1}`);
    if (image.classList.contains("selected"))
      image.classList.remove("selected");
  }
  document.getElementById("rounds-left").textContent = totalRounds + 1;
  displayScores(p1Scoreboard, p1ScoreTemp, p1Score);
  document.getElementById("roll-count").textContent = rollCount;

  // calculate the total score for player 1
  let p1TotalScore = p1Score.reduce((acc, val) => acc + val, 0);
  document.getElementById("p1-total-score").textContent = p1TotalScore;
}

function initGame() {
  resetScores();
  p1Scoreboard = document.getElementsByClassName("scoreDisplay");
}

function resetScores() {
  p1Score = fillArray(0, 20);
  p2Score = fillArray(0, 20);
  p1ScoreTemp = fillArray(0, 20);
  p2ScoreTemp = fillArray(0, 20);
  p1totalscore = 0;
}

function fillArray(content, amount) {
  let newArray = [];
  for (let i = 0; i < amount; i++) {
    newArray.push(content);
  }
  return newArray;
}

function total(array, getal) {
  let total = 0;

  for (let i = 0; i < array.length; i++) {
    if (array[i] === getal) {
      total += getal;
    }
  }

  return total;
}

function totalValue(numberArray) {
  let total = 0;

  for (let i = 0; i < numberArray.length; i++) {
    total += numberArray[i];
  }
  return total;
}

function count(countNumber) {
  let totalones = 0;

  for (let i = 0; i < diceArray.length; i++) {
    if (diceArray[i] === countNumber) {
      totalones++;
    }
  }

  return totalones;
}

function consecutiveNumbers(numberArray) {
  let i;
  for (i = 1; i < numberArray.length; i++) {
    if (numberArray[i] !== numberArray[0] + i) return i;
  }
  return i;
}

function ofAKind() {
  let multiplesArray = [
    count(1),
    count(2),
    count(3),
    count(4),
    count(5),
    count(6),
  ];
  let scoreArray = [0, 0, 0, 0];

  if (multiplesArray.includes(3)) {
    scoreArray[0] = totalValue(diceArray);
  }

  if (multiplesArray.includes(4)) {
    scoreArray[1] = totalValue(diceArray);
  }

  if (multiplesArray.includes(3) && multiplesArray.includes(2)) {
    scoreArray[2] = 25;
  }

  if (multiplesArray.includes(5)) {
    scoreArray[3] = 50;
  }

  return scoreArray;
}

function straights() {
  let combo = consecutiveNumbers(diceArray);
  let scoreArray = [0, 0];
  if (combo === 4) scoreArray[0];
  if (combo === 5) scoreArray[1];
  return scoreArray;
}

function checkSingles() {
  return [
    count(1),
    count(2) * 2,
    count(3) * 3,
    count(4) * 4,
    count(5) * 5,
    count(6) * 6,
  ];
}
