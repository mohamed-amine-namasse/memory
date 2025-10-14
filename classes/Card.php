<?php


class Card {
    public int $id;
    public string $emoji;

    public function __construct(int $id, string $emoji) {
        $this->id = $id;
        $this->emoji = $emoji;
    }



public function renderCardHtml(int $index, bool $isFlipped = false, bool $isFound = false): string {
    $showEmoji = ($isFlipped || $isFound);
    $disabled = $isFound ? 'disabled' : '';
    return "
        <form method='post' style='display:inline'>
            <input type='hidden' name='flip' value='$index'>
            <button type='submit' class='card' $disabled>
                <span class='card-face card-front' style='display:" . ($showEmoji ? 'none' : 'flex') . ";'>?</span>
                <span class='card-face card-back' style='display:" . ($showEmoji ? 'flex' : 'none') . ";'>" . htmlspecialchars($this->getEmoji()) . "</span>
            </button>
        </form>
    ";
}


  


    
    
   public function getEmoji(): string {
        return $this->emoji;
    }}