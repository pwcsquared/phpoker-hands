<?php declare(strict_types=1);

include __DIR__ . "/Card.php";

class Hand {
  private array $cards;

  public function __construct(array $cards) {
    $this->cards = array_map(function($card) { return new Card($card); }, $cards);
  }

  public function __toString() {
    return implode(" ", $this->cards);
  }

  public function is_winner(Hand $secondHand) {
    $firstPlayerRank = $this->get_hand_rank();
    $secondPlayerRank = $secondHand->get_hand_rank();

    if ($firstPlayerRank > $secondPlayerRank) {
      return true;
    } elseif ($firstPlayerRank == $secondPlayerRank) {
      return $this->wins_tie($secondHand);
    } else {
      return false;
    }
  }

  private function wins_tie(Hand $p2) {
    $p1Sets = array_filter($this->find_sets(), "only_sets");
    $p2Sets = array_filter($p2->find_sets(), "only_sets");
    arsort($p1Sets);
    arsort($p2Sets);

    $p1HighCards = array_filter($this->find_sets(), "only_singles");
    $p2HighCards = array_filter($p2->find_sets(), "only_singles");
    krsort($p1HighCards);
    krsort($p2HighCards);

    foreach($p1Sets as $p1Rank => $count) {
      $p2Rank = key($p2Sets);
      if ($p1Rank > $p2Rank) {
        return true;
      } elseif ($p1Rank < $p2Rank) {
        return false;
      } 
      next($p2Sets);
    }

    foreach($p1HighCards as $p1Rank => $count) {
      $p2Rank = key($p2HighCards);
      if ($p1Rank > $p2Rank) {
        return true;
      } elseif ($p1Rank < $p2Rank) {
        return false;
      } 
      next($p2HighCards);
    }

    return false;
  }

  public function get_hand_rank() {
    if ($this->is_straight_flush()) {
      return 9;
    } elseif ($this->is_four_of_a_kind()) {
      return 8;
    } elseif ($this->is_full_house()) {
      return 7;
    } elseif ($this->is_flush()) {
      return 6;
    } elseif ($this->is_straight()) {
      return 5;
    } elseif ($this->is_three_of_a_kind()) {
      return 4;
    } elseif ($this->is_two_pair()) {
      return 3;
    } elseif ($this->is_pair()) {
      return 2;
    } else {
      return 1;
    }
  }

  private function is_straight_flush() {
    return $this->is_straight() && $this->is_flush();
  }

  private function is_four_of_a_kind() {
    $sets = $this->find_sets();
    return in_array(4, $sets);
  }
  
  private function is_full_house() {
    $sets = $this->find_sets();
    return in_array(3, $sets) && in_array(2, $sets);
  }

  private function is_flush() {
    $suit = $this->cards[0]->get_suit();
    
    foreach ($this->cards as $card) {
      if ($card->get_suit() != $suit) {
        return false;
      }
    }

    return true;
  }

  private function is_straight() {
    $this->order_by_rank();
    $rank = $this->cards[0]->get_rank();

    foreach ($this->cards as $card) {
      if ($card->get_rank() != $rank) {
        return false;
      }
      $rank++;
    }

    return true;
  }

  private function is_three_of_a_kind() {
    $sets = $this->find_sets();
    return in_array(3, $sets);
  }
  
  private function is_two_pair() {
    $sets = $this->find_sets();
    return count(array_filter($sets, function($val) { return $val == 2; })) == 2;
  }
  
  private function is_pair() {
    $sets = $this->find_sets();
    return in_array(2, $sets);
  }
  
  public function order_by_rank() {
    usort($this->cards, array("Card", "compare_rank"));
  }
  
  private function find_sets() {
    $ranks = array();
    foreach ($this->cards as $card) {
      if (array_key_exists($card->get_rank(), $ranks)) {
        $ranks[$card->get_rank()] += 1;
      } else {
        $ranks[$card->get_rank()] = 1;
      }
    }
    return $ranks;
  }
}

function only_sets(int $rankCount) {
  return $rankCount > 1;
}

function only_singles(int $rankCount) {
  return $rankCount == 1;
}

?>
