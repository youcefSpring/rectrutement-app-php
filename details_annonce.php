<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "recrutement");

// Check if the ID is provided
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Fetch annonce details
    $query = "SELECT * FROM annonce WHERE id='$id'";
    $result = mysqli_query($connection, $query);
    $annonce = mysqli_fetch_assoc($result);

    // Fetch applications related to the annonce
    $query_offre = "SELECT offre.id AS offre_id, offre.status, candidat.nom, candidat.prenom 
                    FROM offre 
                    JOIN candidat ON offre.candidat_id = candidat.id 
                    WHERE offre.annonce_id='$id'";
    $result_offre = mysqli_query($connection, $query_offre);
} else {
    header('Location: dashboard.php');
    exit();
}

// Handle status update if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $offre_id = isset($_POST['offre_id']) ? intval($_POST['offre_id']) : 0;
    $status = isset($_POST['status']) ? intval($_POST['status']) : 0;

    if ($offre_id > 0) {
        $query_update = "UPDATE offre SET status='$status' WHERE id='$offre_id'";
        mysqli_query($connection, $query_update);

        // Redirect to the same page to show updated information
        header("Location: details_annonce.php?id=$id");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de l'Annonce</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Détails de l'Annonce</h1>
    <h2><?php echo htmlspecialchars($annonce['titre_poste']); ?></h2>
    <p><strong>Date d'Expiration:</strong> <?php echo htmlspecialchars($annonce['date_expiration']); ?></p>
    <p><strong>Dernier Délai d'Inscription:</strong> <?php echo htmlspecialchars($annonce['dernier_delai_inscription']); ?></p>
    <p><strong>Conditions:</strong> <?php echo nl2br(htmlspecialchars($annonce['conditions'])); ?></p>
    
    <h3>Liste des Offres</h3>
    <?php if (mysqli_num_rows($result_offre) > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result_offre)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nom']); ?></td>
                        <td><?php echo htmlspecialchars($row['prenom']); ?></td>
                        <td>
                            <?php
                            switch ($row['status']) {
                                case 0:
                                    echo 'Refusé';
                                    break;
                                case 1:
                                    echo 'Accepté';
                                    break;
                                case 2:
                                    echo 'En Attente';
                                    break;
                            }
                            ?>
                        </td>
                        <?php if ($row['status'] == 2){ ?>
                        <td>
                            <form method="post" action="">
                                <input type="hidden" name="offre_id" value="<?php echo htmlspecialchars($row['offre_id']); ?>">
                                <input type="hidden" name="status" value="1">
                                <button type="submit" class="btn btn-success">Accepter</button>
                            </form>
                            <form method="post" action="" style="display:inline;">
                                <input type="hidden" name="offre_id" value="<?php echo htmlspecialchars($row['offre_id']); ?>">
                                <input type="hidden" name="status" value="0">
                                <button type="submit" class="btn btn-danger">Refuser</button>
                            </form>
                        </td>
                        <?php } else echo "-"; ?>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucune offre pour cette annonce.</p>
    <?php endif; ?>

    <a href="dashboard.php" class="btn btn-secondary">Retour</a>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
