<?php
namespace Classes;

use Config\Database;

class Game {
    public array $cards = [];

    public function __construct(int $pairCount) {
        $this->generateCards($pairCount);
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

    public function renderBoard(): void {
        $i = 0;
        foreach ($this->cards as $card) {
            echo $card->renderCardHtml($i++);
        }
    }
}
