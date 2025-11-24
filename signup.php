<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        die('Email et mot de passe requis');
    }

    // Configuration SMTP pour MailHog
    ini_set('SMTP', 'localhost');
    ini_set('smtp_port', '1025');
    ini_set('sendmail_from', 'noreply@test.local');

    // Préparation de l'email
    $to = $email;
    $subject = 'Confirmation d\'inscription';
    $message = "Bonjour,\n\nVotre inscription a été effectuée avec succès.\n\nEmail: $email\n\nCordialement,\nL'équipe";
    $headers = "From: noreply@test.local\r\n" .
        "Reply-To: noreply@test.local\r\n" .
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
