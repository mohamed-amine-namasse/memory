<?php
require 'config.php';
$stmt = $pdo->query("
  SELECT u.username, MIN(s.moves) as best_moves
  FROM scores s
  JOIN users u ON u.id = s.user_id
  GROUP BY user_id
  ORDER BY best_moves ASC
  LIMIT 10
");
$leaders = $stmt->fetchAll();
?>
<h2>Top 10 joueurs</h2>
<ol>
  <?php foreach ($leaders as $player): ?>
    <li><?= htmlspecialchars($player['username']) ?> - <?= $player['best_moves'] ?> coups</li>
  <?php endforeach; ?>
</ol>