<?php
namespace Classes;
use Config\Database;

class Game {
    public array $cards = [];
    public array $flipped = [];
    public array $found = [];
    public int $moves = 0;
    public int $pairCount;
   public function __construct(int $pairCount)
{
    $this->pairCount = $pairCount;

    $previousPairCount = $_SESSION['game_pair_count'] ?? null;

    // Si le nombre de paires a changé ou aucune carte en session, on régénère tout
    if (!isset($_SESSION['game_cards']) || $previousPairCount !== $pairCount) {
        $this->generateCards($pairCount);
        $_SESSION['game_cards'] = serialize($this->cards);
        $_SESSION['game_pair_count'] = $pairCount;

        // Réinitialise les autres états du jeu
        $_SESSION['game_moves'] = 0;
        $_SESSION['game_found'] = [];
        $_SESSION['game_flipped'] = [];
    } else {
        $this->cards = unserialize($_SESSION['game_cards']);
    }

    // Restaurer les autres états depuis la session
    $this->moves = $_SESSION['game_moves'] ?? 0;
    $this->found = $_SESSION['game_found'] ?? [];
    $this->flipped = $_SESSION['game_flipped'] ?? [];
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
    
public function handleClick(int $index)
{
    // Si déjà trouvée ou déjà retournée, on ignore
    if (in_array($index, $this->found) || in_array($index, $this->flipped)) {
        return;
    }

    // Si déjà 2 cartes retournées non trouvées, on les cache (pas une paire)
    if (count($this->flipped) === 2) {
        $this->flipped = []; // on cache les précédentes
    }

    // On retourne la nouvelle carte
    $this->flipped[] = $index;

    // Si deux cartes sont maintenant retournées, on vérifie la paire
    if (count($this->flipped) === 2) {
        $this->moves++; // nouveau coup

        $firstCard = $this->cards[$this->flipped[0]];
        $secondCard = $this->cards[$this->flipped[1]];

        if ($firstCard->id === $secondCard->id) {
            // C’est une paire
            $this->found[] = $this->flipped[0];
            $this->found[] = $this->flipped[1];
            $this->flipped = []; // on peut les retirer de flipped
        }
        // Sinon, on laisse les 2 cartes visibles temporairement
        // Elles seront cachées au prochain clic
    }

    // Mise à jour de la session
    $_SESSION['game_flipped'] = $this->flipped;
    $_SESSION['game_found'] = $this->found;
    $_SESSION['game_moves'] = $this->moves;
}

    

public function renderBoard(): void {
    foreach ($this->cards as $i => $card) {
        echo $card->renderCardHtml(
            $i,
            in_array($i, $this->flipped),
            in_array($i, $this->found)
        );
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