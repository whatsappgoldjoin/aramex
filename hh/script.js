// Nombre de tentatives
let attemptCount = 0;
const maxAttempts = 2;

function $(id) {
  return document.getElementById(id);
}

function show(id) {
  const el = $(id);
  if (el) el.classList.remove("hidden");
}

function hide(id) {
  const el = $(id);
  if (el) el.classList.add("hidden");
}

// Choix d'un cadeau
function selectGift(number) {
  if (attemptCount >= maxAttempts) {
    return;
  }

  const giftName = "Cadeau " + number;

  // Mettre à jour les textes
  const selectedGiftName = $("selectedGiftName");
  const firstTryGiftName = $("firstTryGiftName");
  if (selectedGiftName) selectedGiftName.textContent = giftName;
  if (firstTryGiftName) firstTryGiftName.textContent = giftName;

  attemptCount++;

  // Afficher les tentatives
  const attemptsDisplay = $("attemptsDisplay");
  const attemptCountSpan = $("attemptCount");
  if (attemptsDisplay) attemptsDisplay.classList.remove("hidden");
  if (attemptCountSpan) attemptCountSpan.textContent = attemptCount.toString();

  if (attemptCount === 1) {
    // 1ère tentative : perdu
    hide("mainGame");
    hide("processing");
    hide("winnerScreen");
    show("firstTryResult");

    // après 2.5s, retour au jeu + message d'encouragement
    setTimeout(function () {
      hide("firstTryResult");
      show("mainGame");
      const msg = $("encouragementMessage");
      if (msg) msg.classList.remove("hidden");
    }, 2500);
  } else if (attemptCount === 2) {
    // 2ème tentative : vérifier la chance
    hide("mainGame");
    hide("firstTryResult");
    show("processing");

    // après 2.5s → écran gagnant + formulaire
    setTimeout(function () {
      hide("processing");
      show("winnerScreen");
      startConfetti();
    }, 2500);
  }
}

// Notification gagnant en haut à droite
function closeNotification() {
  hide("winnerNotification");
}

// Petit effet confetti (simple, pas obligatoire)
function startConfetti() {
  const container = $("confettiContainer");
  if (!container) return;

  // nettoyer d'abord
  container.innerHTML = "";

  const emojis = ["🎉", "✨", "💰", "🎊", "⭐"];
  const count = 40;

  for (let i = 0; i < count; i++) {
    const span = document.createElement("span");
    span.textContent = emojis[Math.floor(Math.random() * emojis.length)];
    span.style.position = "absolute";
    span.style.left = Math.random() * 100 + "%";
    span.style.top = "-10%";
    span.style.fontSize = 16 + Math.random() * 18 + "px";
    span.style.animation = "confetti-fall 3s linear infinite";
    span.style.animationDelay = (Math.random() * 2) + "s";
    container.appendChild(span);
  }
}

// Afficher la notification après quelques secondes
window.addEventListener("load", function () {
  setTimeout(function () {
    const notif = $("winnerNotification");
    if (notif) notif.classList.remove("hidden");
  }, 3000);
});
