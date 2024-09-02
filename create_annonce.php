<?php
session_start();
if (!isset($_SESSION['agent_id'])) {
    header('Location: login.php');
    exit();
}

$connection = mysqli_connect("localhost", "root", "", "recrutement");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titre_poste = $_POST['titre_poste'];
    $date_expiration = $_POST['date_expiration'];
    $dernier_delai_inscription = $_POST['dernier_delai_inscription'];
    $conditions = $_POST['conditions'];
    $agent_id = $_SESSION['agent_id'];

    $query = "INSERT INTO annonce (titre_poste, date_expiration, dernier_delai_inscription, conditions) 
              VALUES ('$titre_poste', '$date_expiration', '$dernier_delai_inscription', '$conditions')";
    mysqli_query($connection, $query);

    header('Location: dashboard.php?success=1');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer une Annonce</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Créer une Annonce</h1>
    <form method="post">
        <div class="form-group">
            <label for="titre_poste">Titre du Poste</label>
            <input type="text" class="form-control" id="titre_poste" name="titre_poste" required>
        </div>
        <div class="form-group">
            <label for="date_expiration">Date d'Expiration</label>
            <input type="date" class="form-control" id="date_expiration" name="date_expiration" required>
        </div>
        <div class="form-group">
            <label for="dernier_delai_inscription">Dernier Délai d'Inscription</label>
            <input type="date" class="form-control" id="dernier_delai_inscription" name="dernier_delai_inscription" required>
        </div>
        <div class="form-group">
            <label for="conditions">Conditions</label>
            <textarea class="form-control" id="conditions" name="conditions" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Créer Annonce</button>
    </form>
</div>
</body>
</html>
