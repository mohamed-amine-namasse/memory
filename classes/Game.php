<?php
namespace Classes;
use Config\Database;

class Game {
    public array $cards = [];
    public array $flipped = [];
    public array $found = [];
    public int $moves = 0;
    public int $pairCount;
    public function __construct(int $pairCount) {
        $this->pairCount = $pairCount;
        $this->generateCards($pairCount);
        // Restaurer moves depuis la session si disponible
    if (isset($_SESSION['game_moves'])) {
        $this->moves = $_SESSION['game_moves'];
    }
    if (isset($_SESSION['game_found'])) {
        $this->found = $_SESSION['game_found'];
    }
    if (isset($_SESSION['game_flipped'])) {
        $this->flipped = $_SESSION['game_flipped'];
    }

    }

    private function generateCards(int $pairCount): void {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT id, emoji FROM cards ORDER BY RAND() LIMIT ?");
        $stmt->bindValue(1, $pairCount, \PDO::PARAM_INT);
        $stmt->execute();

        $selected = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($selected as $cardData) {
            $card = new Card($cardData['id'], $cardData['emoji']);
            // Chaque carte apparaît deux fois
            $this->cards[] = $card;
            $this->cards[] = new Card($cardData['id'], $cardData['emoji']);
        }

        shuffle($this->cards);
    }
    public function handleClick(int $index): void {
        if (in_array($index, $this->flipped) || in_array($index, $this->found)) {
            return;
        }

        $this->flipped[] = $index;

        if (count($this->flipped) === 2) {
            $this->moves++;

            $first = $this->cards[$this->flipped[0]];
            $second = $this->cards[$this->flipped[1]];

            if ($first->getEmoji() === $second->getEmoji()) {
                $this->found[] = $this->flipped[0];
                $this->found[] = $this->flipped[1];
            }

            $this->flipped = [];
        }

        // Mise à jour de la session
        $_SESSION['game_flipped'] = $this->flipped;
        $_SESSION['game_found'] = $this->found;
        $_SESSION['game_moves'] = $this->moves;
    }
    public function renderBoard(): void {
        //$i = 0;
        /*foreach ($this->cards as $card) {
            echo $card->renderCardHtml($i++);
        }*/
         foreach ($this->cards as $i => $card) {
            $isFlipped = in_array($i, $this->flipped);
            $isFound = in_array($i, $this->found);

            echo "<form method='post' style='display:inline'>";
            echo "<input type='hidden' name='flip' value='$i'>";
            echo "<button type='submit' class='card " . ($isFound ? 'found' : '') . "'>";

            if ($isFlipped || $isFound) {
                echo $card->getEmoji();
            } else {
                echo "?";
            }

            echo "</button>";
            echo "</form>";
        }
    }
        
     public function isFinished(): bool {
        return count($this->found) === $this->pairCount * 2;
    }

    public function getScore(): float {
        return $this->pairCount > 0 ? round($this->moves / $this->pairCount, 2) : 0;
    }

    public function getMoves(): int {
        return $this->moves;
    }

    public function getPairCount(): int {
        return $this->pairCount;
    }
   
    public function resetGame(): void {
        unset($_SESSION['game_cards']);
        unset($_SESSION['game_flipped']);
        unset($_SESSION['game_found']);
        unset($_SESSION['game_moves']);
        unset($_SESSION['game_initialized']);
    }
}