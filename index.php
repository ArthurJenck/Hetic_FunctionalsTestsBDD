<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="background"></div>
    <form action="./signup.php" method="POST">
        <h1>Formulaire d'inscription</h1>
        <div>
            <label for="email">Adresse mail*</label>
            <input type="email" id="email" name="email" required autocomplete="email">
        </div>

        <div>
            <label for="password">Mot de passe*</label>
            <input type="password" id="password" name="password" required autocomplete="password">
        </div>

        <button type="submit">Envoyer</button>
    </form>
</body>

</html>