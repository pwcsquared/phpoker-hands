<?php
declare(strict_types=1);

class Card {
  private string $rank;
  private string $suit;

  public function __construct(string $cardString) {
    $this->rank = substr($cardString, 0, 1);
    $this->suit = substr($cardString, 1, 1);
  }

  public function __toString() {
    return $this->rank . $this->suit;
  }

  public function get_rank() {
    switch ($this->rank) {
      case "A":
        return 14;
      case "K":
        return 13;
      case "Q":
        return 12;
      case "J":
        return 11;
      case "T":
        return 10;
      default:
        return intval($this->rank);
    }
  }

  public function get_suit() {
    return $this->suit;
  }

  public function is_higher_rank(Card $card) {
    return $this->get_rank() > $card->get_rank();
  }

  static public function compare_rank(Card $a, Card $b) {
    return $a->get_rank() > $b->get_rank();
  }
}

?>
