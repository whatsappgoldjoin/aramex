<?php
// =================================================================
// 🚨 ÉTAPE 1 : CONFIGURATION TÉLÉGRAM
// REMPLACEZ 'VOTRE_BOT_TOKEN' et 'VOTRE_CHAT_ID' PAR VOS VRAIES VALEURS
// =================================================================
$BOT_TOKEN = '6295685387:AAHb6p_xt8yrrMP918_sLdGKy_7ITJZ5beE'; // Ex: 123456:ABC-DEF1234 (Obtenu via BotFather)
$CHAT_ID = '-5061239044';     // Ex: -123456789 ou un nom d'utilisateur de canal

// =================================================================
// ÉTAPE 2 : RÉCUPÉRATION DES DONNÉES
// =================================================================
// Récupère la valeur du champ 'choice' envoyé par le formulaire POST.
$user_choice = isset($_POST['choice']) ? $_POST['choice'] : 'ERREUR: Donnée de choix non reçue.';

// Préparer le message à envoyer
$message = "⭐ Nouveau Choix Reçu ⭐\n\n";
$message .= "➡️ Choix: " . $user_choice . "\n";
$message .= "📅 Heure: " . date('Y-m-d H:i:s');

// =================================================================
// ÉTAPE 3 : ENVOI À TÉLÉGRAM
// =================================================================

// 1. Encoder le message pour être sûr qu'il passe dans l'URL
$encoded_text = urlencode($message);

// 2. Construire l'URL de l'API Telegram (méthode simple via file_get_contents)
$api_url = "https://api.telegram.org/bot" . $BOT_TOKEN . "/sendMessage?chat_id=" . $CHAT_ID . "&text=" . $encoded_text;

// 3. Envoyer la requête et vérifier le résultat
$response = @file_get_contents($api_url);

// =================================================================
// ÉTAPE 4 : REDIRECTION ET FEEDBACK
// =================================================================
if ($response !== FALSE) {
    $result = json_decode($response, true);
    
    if (isset($result['ok']) && $result['ok'] === true) {
        // Succès : Le message a été envoyé
        
        // Ceci affiche un message de succès puis redirige vers 'index.html' après 3 secondes.
        echo '
            <!DOCTYPE html>
            <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="refresh" content="3;url=index.html"> 
                <title>Succès</title>
                <style>body { font-family: Arial, sans-serif; text-align: center; padding-top: 50px; } .success { color: green; }</style>
            </head>
            <body>
                <h1 class="success">✅ ENVOI RÉUSSI !</h1>
                <p>Votre information a été envoyée à Telegram. Redirection vers la page d\'accueil dans 3 secondes...</p>
            </body>
            </html>
        ';
    } else {
        // Erreur API (Token ou Chat ID incorrect)
        $error_message = isset($result['description']) ? htmlspecialchars($result['description']) : 'Erreur inconnue lors de l\'envoi.';
        echo '
            <!DOCTYPE html>
            <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <title>Erreur</title>
                <style>body { font-family: Arial, sans-serif; text-align: center; padding-top: 50px; } .error { color: red; }</style>
            </head>
            <body>
                <h1 class="error">❌ ERREUR D\'ENVOI !</h1>
                <p>Impossible d\'envoyer le message à Telegram.</p>
                <p><strong>Détails:</strong> ' . $error_message . '</p>
                <p>Vérifiez le <strong>\$BOT_TOKEN</strong> et <strong>\$CHAT_ID</strong> dans send.php.</p>
            </body>
            </html>
        ';
    }
} else {
    // Erreur de connexion ou de serveur (ex: file_get_contents désactivé, URL invalide)
    echo '
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Erreur Serveur</title>
            <style>body { font-family: Arial, sans-serif; text-align: center; padding-top: 50px; } .error { color: red; }</style>
        </head>
        <body>
            <h1 class="error">❌ ERREUR SERVEUR !</h1>
            <p>Le serveur n\'a pas pu contacter l\'API Telegram. Vérifiez votre connexion ou les paramètres PHP.</p>
        </body>
        </html>
    ';
}

exit();
?>