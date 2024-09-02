<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if (isset($_SESSION['agent_id'])) {
    header('Location: dashboard.php');
    exit();
}

else{
$connection = mysqli_connect("localhost", "root", "", "recrutement");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get and sanitize input

    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = md5($_POST['password']); // Password should be managed securely
   
    // Query to fetch the agent's details
    $query = "SELECT * FROM agent WHERE email='$email' and password ='$password'";
    $result = mysqli_query($connection, $query);

    // Check if any record was returned
    if ($agent = mysqli_fetch_assoc($result)) {
        var_dump($agent);
        // Verify the password
        if ($agent) {
            // Password is correct
            $_SESSION['agent_id'] = $agent['id'];
            $_SESSION['agent_name'] = $agent['nom'] . ' ' . $agent['prenom']; // Optional: Store agent's name
            header('Location: dashboard.php'); // Redirect to dashboard
            exit(); // Ensure no further code is executed
        } else {
            // Password is incorrect
            echo "Email ou mot de passe incorrect.";
        }
    } else {
        // Email not found
        echo "Email ou mot de passe incorrect.";
    }
    
    mysqli_close($connection);
}
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Agent</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
   
   <center>
   <h1>Connexion Agent</h1>
   <form method="post">
        <div class="form-group col-md-6">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group col-md-6">
            <label for="password">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
   </center>
</div>
</body>
</html>
