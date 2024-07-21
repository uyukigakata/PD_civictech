const questions = [
  {
    question: "シビックテックとは技術を使用して課題を解決する〇か×か",
    answer: false,
    explanation: "シビックテックは技術だけでなく市民も必要である"
  },
  {
    question: "募集した地域課題を解決するのは企業である〇か×か",
    answer: false,
    explanation: "立候補した市民がチームとなって解決する"
  },
  {
    question: "シビックテックが発足したのはX年",
    answer: true,
    explanation: "シビックテックが発足したのはX年。日本はY年。"
  }
];

let currentQuestion = 0;
let correctAnswers = 0;

function displayQuestion() {
  const questionText = document.getElementById("question");
  questionText.textContent = questions[currentQuestion].question;

  const resultText = document.getElementById("result");
  const explanationText = document.getElementById("explanation");
  resultText.textContent = "";
  explanationText.textContent = "";

  const nextQuestionLink = document.getElementById("nextQuestionLink");
  nextQuestionLink.style.display = "none";
}

function checkAnswer(userAnswer) {
  const correctAnswer = questions[currentQuestion].answer;
  const resultText = document.getElementById("result");
  const explanationText = document.getElementById("explanation");
  const trueButton = document.querySelector('button:nth-of-type(1)');
  const falseButton = document.querySelector('button:nth-of-type(2)');

  trueButton.disabled = true;
  falseButton.disabled = true;

  if (userAnswer === correctAnswer) {
    resultText.textContent = "正解です！";
    explanationText.textContent = questions[currentQuestion].explanation;
    correctAnswers++;
  } else {
    resultText.textContent = "不正解です。";
    explanationText.textContent = `正解は「${correctAnswer ? '〇' : '×'}」です。${questions[currentQuestion].explanation}`;
  }

  const nextQuestionLink = document.getElementById("nextQuestionLink");
  nextQuestionLink.style.display = "inline";
  nextQuestionLink.removeEventListener("click", goToNextQuestion);
  nextQuestionLink.addEventListener("click", goToNextQuestion);
}

function goToNextQuestion(event) {
  event.preventDefault();
  currentQuestion++;
  if (currentQuestion < questions.length) {
    displayQuestion();
  } else {
    showScore();
  }

  const trueButton = document.querySelector('button:nth-of-type(1)');
  const falseButton = document.querySelector('button:nth-of-type(2)');

  // ボタンを有効化
  trueButton.disabled = false;
  falseButton.disabled = false;
}

function showScore() {
  const scoreText = document.getElementById("score");
  scoreText.style.display = "block";
  scoreText.textContent = `あなたは${correctAnswers}問合っていました`;
}

// 最初の問題を表示
displayQuestion();