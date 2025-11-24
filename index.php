<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>

<body>
    <form action="./signup.php" method="POST">
        <h1>Formulaire d'inscription</h1>
        <label for="email">Adresse mail*</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Mot de passe*</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Envoyer</button>
    </form>
</body>

</html>