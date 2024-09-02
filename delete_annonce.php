<?php
$connection = mysqli_connect("localhost", "root", "", "recrutement");
// Include your database connection file
session_start(); // Start the session if needed

// Check if the form was submitted using POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get and sanitize the ID
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if ($id > 0) {
        // Prepare and execute the deletion query
        $query = "DELETE FROM offre WHERE annonce_id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $id);


        $query_2 = "DELETE FROM annonce WHERE id = ?";
        $stmt_2 = $connection->prepare($query_2);
        $stmt_2->bind_param("i", $id);
        
        if ($stmt->execute() && $stmt_2->execute()) {
            // Successful deletion
            header('Location: dashboard.php?success=1'); // Redirect to the index page with a success message
            exit();
        } else {
            // Failed deletion
            echo "Erreur lors de la suppression.";
        }

        $stmt->close();
    } else {
        // Invalid ID
        echo "ID invalide.";
    }

    $connection->close();
} else {
    // Invalid request method
    echo "Méthode de requête invalide.";
}
?>
