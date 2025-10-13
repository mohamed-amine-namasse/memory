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
    $re = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$.!%(+;)\*\/\-_{}#~$*%:!,<²°>ù^`|@[\]*?&]).{8,}$/';

    if (empty($email) || empty($password) || empty($confirm)) {
        $error = "Tous les champs sont obligatoires.";
    } elseif ($password !== $confirm) {
        $error = "Les mots de passe ne correspondent pas.";
    } elseif (!preg_match($re, $password))
    {$error= "Mot de passe non sécurisé ! Veuillez ajouter au moins une minuscule, une majuscule, un chiffre, un caractère spécial ainsi qu'un minimum de 8 caractères au total";}
     else {
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
     <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
        <!-- Load an icon library -->
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
   <header>
        <ul>
           
            <?php if (!isset($_SESSION['email'])): ?>
                    <li>

                        <a href="./login.php" class="#">
                            <div class="icon">
                                <i class="fa fa-user-circle-o"></i>
                            </div>
                            <div class="name">Se connecter</div>
                        </a>

                    </li>
                    <li>
                        <a href="./register.php" class="active">
                            <div class="icon">
                                <i class="fa fa-user-plus"></i>
                            </div>
                            <div class="name">Inscription</div>
                        </a>
                    </li>
            <?php else: ?>
                    
                    <li>
                        <a href="./profile.php" class="#">
                            <div class="icon">
                                <i class="fa fa-user"></i>
                            </div>
                            <div class="name">Profil</div>
                        </a>
                    </li>
                    <li>
                        <a href="./leaderboard.php" class="#">
                            <div class="icon">
                                <i class="fa fa-trophy"></i>
                            </div>
                            <div class="name">Classement</div>
                        </a>
                    </li>
                    <li>
                        <a href="./logout.php" class="#">
                            <div class="icon">
                                <i class="fa fa-sign-out"></i>
                            </div>
                            <div class="name">Deconnexion</div>
                        </a>
                    </li>
            <?php endif; ?>
        </ul>
    </header>

    
   <main>
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
                        <input type="text" name="password" placeholder="Au moins 8 caractères,Maj+Min,caractere special"><br>
                        <label><b>Confirmation Password:</b></label><br>
                        <input type="text" name="confirm_password" placeholder="Confirmez votre mot de passe">
                        <div class=btn>
                            <input class=bouton_submit type="submit" value="S'inscrire">
                        </div>
                        <p>Déjà un compte ? <a href="login.php">Connexion</a></p>
                    </form>
                
                </div>
                
            </div>
        
    </main>

    
</body>
</html>