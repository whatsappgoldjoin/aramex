<?php
// ===============================
//  Logger Visiteur - Accueil
//  Simple + compatible PHP 5.x
// ===============================

// DEBUG (optionnel) : décommenter pour voir les erreurs PHP
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// === CONFIG TELEGRAM ===
$botToken = '6417708035:AAGQ0w-ryvgMcp9QmUMeB1wbfbGu69ngY_c';
$chatId   = '5061239044';

// === COMPTEUR VISITEURS ===
$counterFile = __DIR__ . '/visitors-counter.txt';
$visitorNumber = 1;
if (file_exists($counterFile)) {
    $old = trim(file_get_contents($counterFile));
    if ($old !== '') {
        $visitorNumber = (int)$old + 1;
    }
}
file_put_contents($counterFile, (string)$visitorNumber);

// === IP & USER AGENT ===
$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'inconnue';
if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] . ' (proxy: ' . $ip . ')';
}
$userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Inconnu';

// === MESSAGE TELEGRAM ===
$message  = "Nouveau visiteur sur la page d'accueil\n\n";
$message .= "Visitor #" . $visitorNumber . "\n";
$message .= "IP : " . $ip . "\n";
$message .= "User Agent : " . $userAgent . "\n";

// === ENVOI VERS TELEGRAM ===
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
        'content' => http_build_query($data)
    )
);

$context  = stream_context_create($options);
$result   = @file_get_contents($telegramUrl, false, $context);

// === RÉPONSE SIMPLE (JSON) ===
header('Content-Type: application/json');
echo json_encode(array('status' => 'ok', 'visitor' => $visitorNumber));
exit;
?>
