<?php
namespace Classes;

class Card {
    public int $id;
    public string $emoji;

    public function __construct(int $id, string $emoji) {
        $this->id = $id;
        $this->emoji = $emoji;
    }

    public function renderCardHtml(int $index): string {
        return '
        <label class="card">
            <input type="checkbox" name="card' . $index . '" />
            <div class="inner">
                <div class="front">?</div>
                <div class="back">' . htmlspecialchars($this->emoji) . '</div>
            </div>
        </label>';
    }
}