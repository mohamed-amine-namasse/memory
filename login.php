<?php
session_start();


require 'classes/User.php';
 



// Redirection si déjà connecté
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
 $error = '';      // Message d'erreur à afficher à l'utilisateur
        


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

                        <a href="./login.php" class="active">
                            <div class="icon">
                                <i class="fa fa-user-circle-o"></i>
                            </div>
                            <div class="name">Se connecter</div>
                        </a>

                    </li>
                    <li>
                        <a href="./register.php" class="#">
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
                
                </form>
                <p>Pas encore de compte ? <a href="register.php">Créer un compte</a></p>
            </div> 
            
        </div>

       
</main>
</body>
</html>