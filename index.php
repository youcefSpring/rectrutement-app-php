<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "recrutement");

$query = "SELECT * FROM annonce ";
$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Annonces</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6">
        <h1>Liste des Annonces</h1>
        </div>
        <div class="col-md-6">
           <h1>
           <a href="login.php">Connexion</a>
           </h1>        
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Titre du Poste</th>
                <th>Date d'Expiration</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['titre_poste']; ?></td>
                    <td><?php echo $row['date_expiration']; ?></td>
                    <td>
                        <?php
                         $currentDate =date("Y-m-d");
                          
                        if ($row['date_expiration'] >= $currentDate ) { ?>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#inscriptionModal<?php echo $row['id']; ?>">S'inscrire</button>
                        <!-- Modal d'inscription -->
<div class="modal fade" id="inscriptionModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="inscriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inscriptionModalLabel">Inscription</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulaire d'inscription -->
                <form action="#" method="POST">
                    <!-- Champ caché pour l'ID de l'annonce -->
                    <input type="hidden" name="annonce_id" id="annonce_id" value="<?php echo $row['id']; ?>">

                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prénom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="telephone">Téléphone</label>
                        <input type="tel" class="form-control" id="telephone" name="telephone" required>
                    </div>
                    <div class="form-group">
                        <label for="telephone">adresse</label>
                        <input type="text" class="form-control" id="adresse" name="adresse" required>
                    </div>
                    <button type="submit" class="btn btn-primary">S'inscrire</button>
                </form>
            </div>
        </div>
    </div>
</div>
   <?php } else echo '';  ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $annonce_id = $_POST['annonce_id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $adresse = $_POST['adresse'];

    // Sanitize input
    $nom = mysqli_real_escape_string($connection, $nom);
    $prenom = mysqli_real_escape_string($connection, $prenom);
    $email = mysqli_real_escape_string($connection, $email);
    $telephone = mysqli_real_escape_string($connection, $telephone);
    $annonce_id = intval($annonce_id);

    // Check if the candidate already exists
    $query = "SELECT id FROM candidat WHERE email = '$email'";
    $result = mysqli_query($connection, $query);
    if (mysqli_num_rows($result) > 0) {
        // Candidate already exists
        $row = mysqli_fetch_assoc($result);
        $candidat_id = $row['id'];
    } else {
        // Insert new candidate
        $query = "INSERT INTO candidat (nom, prenom, email, telephone,adresse) VALUES ('$nom', '$prenom', '$email', '$telephone','$adresse')";
        mysqli_query($connection, $query);
        $candidat_id = mysqli_insert_id($connection);
    }

    // Insert the application
    $query2 = "INSERT INTO offre (annonce_id, candidat_id) VALUES ('$annonce_id', '$candidat_id')";
    mysqli_query($connection, $query2);

    
}
?>

