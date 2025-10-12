<?php
session_start();

require 'config/Database.php';

use Config\Database;

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if (empty($email) || empty($password) || empty($confirm)) {
        $error = "Tous les champs sont obligatoires.";
    } elseif ($password !== $confirm) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        $db = Database::getConnection();

        // Vérifie si l'utilisateur existe déjà
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = "Ce nom d'utilisateur est déjà pris.";
        } else {
            // Hachage du mot de passe
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            $stmt->execute([$email, $hashed]);

            $success = "Compte créé avec succès ! Vous pouvez maintenant vous connecter.";
            header("Refresh:2; url=login.php");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
   

    <?php if ($error): ?>
        <p class="error" ><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p class="success"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

   <div class=container_form>
            <div>
                <h2>Création de compte</h2>
                <br>


                <form id=form action="register.php" method="post">
                    <label><b>Login:</b></label><br>
                    <input type="email" name="email" placeholder="votre@email.com"><br>
                    <label><b>Password:</b></label><br>
                    <input type="text" name="password" placeholder="Votre mot de passe"><br>
                    <label><b>Confirmation Password:</b></label><br>
                    <input type="text" name="confirm_password" placeholder="Confirmez votre mot de passe">
                    <div class=btn>
                        <input class=bouton_submit type="submit" value="S'inscrire">
                    </div>
                </form>
            </div>
        </div>


    <p>Déjà un compte ? <a href="login.php">Connexion</a></p>
</body>
</html>