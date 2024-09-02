<?php
$connection = mysqli_connect("localhost", "root", "", "recrutement");
session_start(); // Start the session if needed

// Check if the form was submitted using POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get and sanitize input
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $titre_poste = isset($_POST['titre_poste']) ? mysqli_real_escape_string($connection, $_POST['titre_poste']) : '';
    $date_expiration = isset($_POST['date_expiration']) ? mysqli_real_escape_string($connection, $_POST['date_expiration']) : '';
    $dernier_delai_inscription = isset($_POST['dernier_delai_inscription']) ? mysqli_real_escape_string($connection, $_POST['dernier_delai_inscription']) : '';
    $conditions = isset($_POST['conditions']) ? mysqli_real_escape_string($connection, $_POST['conditions']) : '';

    if ($id > 0) {
        // Prepare and execute the update query
        $query = "UPDATE annonce SET titre_poste = ?, date_expiration = ?, dernier_delai_inscription = ?, conditions = ? WHERE id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("ssssi", $titre_poste, $date_expiration, $dernier_delai_inscription, $conditions, $id);
        
        if ($stmt->execute()) {
            // Successful update
            header('Location: dashboard.php?success=2'); // Redirect to the index page with a success message
            exit();
        } else {
            // Failed update
            echo "Erreur lors de la mise à jour.";
        }

        $stmt->close();
    } else {
        // Invalid ID
        echo "ID invalide.";
    }

    $connection->close();
    exit();
}

// Get the annonce details if the ID is provided
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    if ($id > 0) {
        $query = "SELECT * FROM annonce WHERE id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($annonce = $result->fetch_assoc()) {
            // Display the form with current data
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Edit Annonce</title>
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            </head>
            <body>
                <div class="container">
                    <h2>Éditer Annonce</h2>
                    <form method="post" action="">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($annonce['id']); ?>">
                        <div class="form-group">
                            <label for="titre_poste">Titre du Poste:</label>
                            <input type="text" class="form-control" id="titre_poste" name="titre_poste" value="<?php echo htmlspecialchars($annonce['titre_poste']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="date_expiration">Date d'Expiration:</label>
                            <input type="date" class="form-control" id="date_expiration" name="date_expiration" value="<?php echo htmlspecialchars($annonce['date_expiration']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="dernier_delai_inscription">Dernier Délai d'Inscription:</label>
                            <input type="date" class="form-control" id="dernier_delai_inscription" name="dernier_delai_inscription" value="<?php echo htmlspecialchars($annonce['dernier_delai_inscription']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="conditions">Conditions:</label>
                            <textarea class="form-control" id="conditions" name="conditions" rows="4" required><?php echo htmlspecialchars($annonce['conditions']); ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </form>
                </div>
                <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
            </body>
            </html>
            <?php
        } else {
            echo "Annonce non trouvée.";
        }

        $stmt->close();
    } else {
        echo "ID invalide.";
    }
} else {
    echo "ID non fourni.";
}

$connection->close();
?>
