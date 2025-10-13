<?php

require 'config/database.php';
use Config\Database;
session_start();

$user_id = $_SESSION['user_id'];
$db = Database::getConnection();
$stmt = $db->query("
  SELECT u.email, MIN(s.moves) as best_moves
  FROM scores s
  JOIN users u ON u.id = s.user_id
  GROUP BY user_id
  ORDER BY best_moves ASC
  LIMIT 10
");
$leaders = $stmt->fetchAll();
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
                <a href="./index.php" class="#">
                    <div class="icon">
                        <i class="fa fa-gamepad"></i>
                    </div>
                    <div class="name">Jouer</div>
                </a>
            </li>
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
                        <a href="./leaderboard.php" class="active">
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
     <div>
        <h2 id="orange">Top 10 joueurs:</h2>
        
        <ol>
          <?php foreach ($leaders as $player): ?>
            <br>

            <li id="big"><b><?= htmlspecialchars($player['email']) ?> - <?= $player['best_moves'] ?> coups</b></li>
          <?php endforeach; ?>
        </ol>
     </div>
  </main>
</body>
</html>