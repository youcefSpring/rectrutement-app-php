<?php
session_start();
if (!isset($_SESSION['agent_id'])) {
    header('Location: login.php');
    exit();
}

$connection = mysqli_connect("localhost", "root", "", "recrutement");
$agent_id = $_SESSION['agent_id'];
$query = "SELECT * FROM annonce";
$result = mysqli_query($connection, $query);

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord Agent</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-4">
        <h1>Tableau de Bord</h1>
        </div>
        <div class="col-md-4 mt-2" >
        <a href="create_annonce.php" class="btn btn-success">Créer une Annonce</a>

        </div>
        <div class="col-md-4 text-right mt-2" >
            
            <form method="post" action="">
                <button type="submit" name="logout" class="btn btn-danger">Logout</button>
            </form>
        
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
                        <a href="details_annonce.php?id=<?php echo $row['id']; ?>" class="btn btn-info">Détails</a>
                        <a href="edit_annonce.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Modifier</a>
                        <form method="post" action="delete_annonce.php" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
