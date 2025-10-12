<?php
require 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM scores WHERE user_id = ? ORDER BY created_at DESC LIMIT 10");
$stmt->execute([$user_id]);
$scores = $stmt->fetchAll();
?>
<h2>Mes scores récents</h2>
<table>
  <tr><th>Date</th><th>Paires</th><th>Coups</th><th>Durée</th></tr>
  <?php foreach ($scores as $score): ?>
    <tr>
      <td><?= $score['created_at'] ?></td>
      <td><?= $score['pairs'] ?></td>
      <td><?= $score['moves'] ?></td>
      <td><?= $score['duration'] ?> sec</td>
    </tr>
  <?php endforeach; ?>
</table>
