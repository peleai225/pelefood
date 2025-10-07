<!DOCTYPE html>
<html>
<head>
    <title>Test - Création Restaurant</title>
    <meta charset="utf-8">
</head>
<body>
    <h1>Test - Création Restaurant</h1>
    <p>Si vous voyez cette page, le problème 403 est résolu !</p>
    <p>Utilisateur connecté : {{ Auth::user()->name ?? "Non connecté" }}</p>
    <p>Rôle : {{ Auth::user()->role ?? "Non défini" }}</p>
    <a href="/">Retour à l'accueil</a>
</body>
</html>