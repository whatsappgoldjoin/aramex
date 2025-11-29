<?php
// ===============================
//  Logger des visites (page d'accueil)
//  Version compatible PHP 5.x
// ===============================

// // Décommentez ces lignes si vous voulez voir les erreurs PHP (debug)
// // error_reporting(E_ALL);
// // ini_set('display_errors', 1);

// Config Telegram
$botToken = '6417708035:AAGQ0w-ryvgMcp9QmUMeB1wbfbGu69ngY_c';
$chatId   = '5061239044'; // ID perso ou ID groupe/canal

// Compteur de visiteurs
$counterFile = __DIR__ . '/visitors-counter.txt';
$visitorNumber = 1;
if (file_exists($counterFile)) {
    $visitorNumber = (int)file_get_contents($counterFile) + 1;
}
file_put_contents($counterFile, (string)$visitorNumber);

// IP + User Agent
$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'inconnue';
if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] . ' (proxy: ' . $ip . ')';
}
$userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Inconnu';

// Message Telegram
$message  = "👀 Nouveau visiteur sur la page d'accueil\n\n";
$message .= "🔢 Visitor #" . $visitorNumber . "\n";
$message .= "💻 IP : " . $ip . "\n";
$message .= "🧩 User Agent : " . $userAgent . "\n";

$telegramUrl = "https://api.telegram.org/bot" . $botToken . "/sendMessage";

$data = array(
    'chat_id'    => $chatId,
    'text'       => $message,
    'parse_mode' => 'Markdown'
);

$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
        'timeout' => 10
    )
);

$context  = stream_context_create($options);
$result   = @file_get_contents($telegramUrl, false, $context);

// Retourner une petite réponse JSON (facultatif)
header('Content-Type: application/json');
echo json_encode(array('status' => 'ok', 'visitor' => $visitorNumber));
exit;
?>
