<?php

require_once __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo ('Email et mot de passe requis');
        return;
    }

    ini_set('SMTP', env('SMTP_HOST'));
    ini_set('smtp_port', env('SMTP_PORT'));
    ini_set('sendmail_from', env('SMTP_FROM_EMAIL'));

    // Préparation de l'email
    $to = $email;
    $subject = 'Confirmation d\'inscription';
    $message = "Bonjour,\n\nVotre inscription a été effectuée avec succès.\n\nEmail: $email\n\nCordialement,\nL'équipe";
    $fromEmail = env('SMTP_FROM_EMAIL');
    $fromName = env('SMTP_FROM_NAME');
    $headers = "From: $fromName <$fromEmail>\r\n" .
        "Reply-To: $fromEmail\r\n" .
        "X-Mailer: PHP/" . phpversion();

    // Envoi de l'email
    if (mail($to, $subject, $message, $headers)) {
        echo "Inscription réussie ! Un email de confirmation a été envoyé à $email";
    } else {
        echo "Erreur lors de l'envoi de l'email";
    }
} else {
    echo 'Méthode non autorisée';
}
