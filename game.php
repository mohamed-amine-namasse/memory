<?php
session_start();



require 'classes/Game.php';


date_default_timezone_set('Europe/Paris');
$pairs = isset($_GET['pairs']) ? (int) $_GET['pairs'] : 6;
$pairs = max(3, min($pairs, 12));

$game = new Game($pairs);
$_SESSION['username']=$_GET['player'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['flip'])) {
    $game->handleClick((int) $_POST['flip']);
}

if (isset($_POST["submit"]) ) {
$user_id=$_POST['user_id'];
$pairs=$_POST['pairs'];
$moves=$_POST['moves'];
$score=$_POST['score'];
$created_at=(new DateTime())->format('Y-m-d H:i:s');
$db = Database::getConnection();
$stmt = $db->prepare("INSERT INTO scores (user_id,pairs,moves,score,created_at) VALUES (?, ?,?,?,?)");
$stmt->execute([$user_id, $pairs,$moves,$score,$created_at]);
header("Location: profile.php");
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
        
            <div class="game-container">
                <?php
                $pairs = isset($_GET['pairs']) ? (int) $_GET['pairs'] : 6;
                $totalCards = $pairs * 2;

                
                switch ($pairs) {
                case 3: $columns = 3; break;
                case 4: $columns = 4; break;
                case 5: $columns = 5; break;
                case 6: $columns = 6; break;
                case 7: $columns = 7; break;
                case 8: $columns = 8; break;
                case 9: $columns = 9; break;
                case 10: $columns = 10; break;
                case 11: $columns =8; break;
                case 12: $columns = 8; break;
                default: $columns = 4;
                }
               
                echo "<div class='game-container' style='display:grid; gap:15px; grid-template-columns: repeat($columns, 1fr);'>";
                $game->renderBoard();
                echo "</div>";
                
                ?>
                <br>
                <p>Paires trouvées : <?= count($game->found) ?> / <?= $game->pairCount * 2 ?></p>
                <br>
                <p>Nombre de coups : <?= $game->getMoves() ?></p>
          
           </div>
                <?php if ($game->isFinished()): ?>
                <div class="score">
                    <h2>Félicitations ! <?= htmlspecialchars($_SESSION['username']) ?> !</h2>
                    <p>Nombre de coups : <?= $game->getMoves() ?></p>
                    <p>Score : <?= $game->getScore() ?></p>
                    
                    <p>Paires trouvées : <?= count($game->found) ?> / <?= $game->pairCount * 2 ?></p> 
                
                    <form method="post" action="game.php">
                        <input type="hidden" name="score" value="<?= $game->getScore() ?>">
                        <input type="hidden" name="moves" value="<?= $game->getMoves() ?>">
                        <input type="hidden" name="pairs" value="<?= $game->getPairCount() ?>">
                        <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?? '' ?>">
                        <br>
                        <button type="submit" name="submit">Enregistrer mon score</button>
                    </form>
               </div>
            <?php endif; ?>
         
    </main>

  
</body>
</html>