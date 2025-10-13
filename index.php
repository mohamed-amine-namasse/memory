<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Jeu Memory</title>
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
            <li>
                <a href="./index.php" class="active">
                    <div class="icon">
                        <i class="fa fa-home"></i>
                    </div>
                    <div class="name">Home</div>
                </a>
            </li>
            <li>
                <a href="./profile.php" class="#">
                    <div class="icon">
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="name">Profil</div>
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
        </ul>
    </header>
    <main>
       <div class=container_form>
            <div>
                <form action="game.php" method="get">
                    <label for="pairs">Nombre de paires :</label>
                    <select name="pairs" id="pairs" required>
                        <?php for ($i = 3; $i <= 12; $i++): ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                    <div class=btn>
                        <input class=bouton_submit type="submit" value="Jouer">
                
                    </div>
                </form> 
           </div>
    </main>
    
</body>
</html>