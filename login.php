<?php
session_start();

require 'config/database.php';
require 'classes/User.php';
 

use Classes\User;

// Redirection si déjà connecté
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
 $message = '';      // Message à afficher à l'utilisateur
        


if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
    if (isset($_POST['email'])&&isset($_POST['password'])){
    $email = trim($_POST['email']);
    $password = $_POST['password'];}
    if (!empty($email) && !empty($password)) {
        
        $user = User::authenticate($email, $password);
        if ($user) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['email'] = $user->email;
            header("Location: index.php");
            exit;
        } else {
            $error = "Nom d'utilisateur ou mot de passe incorrect.";
        }
    } else {
        $error = "Tous les champs sont obligatoires.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
      
        <div class=container_form>
            <div>
                <h2>Connexion</h2>
                <br>
                <form id=form action="login.php" method="post">
                    <label><b>Adresse email:</b></label><br>
                    <input type="text" name="email" placeholder="votre@email.com" ><br>
                    <label><b>Password:</b></label><br>
                    <input type="password" name="password" placeholder="Votre mot de passe">
                    <div class=btn>
                        <input class=bouton_submit type="submit" value="Connexion">
                        
                    </div>
                <p>Pas encore de compte ? <a href="register.php">Créer un compte</a></p>
                </form>
                
            </div>
        </div>

        
</body>
</html>