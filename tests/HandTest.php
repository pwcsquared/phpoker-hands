<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class HandTest extends TestCase {
  public function testGetsHandRankForHighCard() {
    $hand = new Hand(["AS", "2S", "4C", "6H", "8D"]);
    $this->assertEquals($hand->get_hand_rank(), 1);
  }

  public function testGetsHandRankForPair() {
    $hand = new Hand(["AS", "AD", "4C", "6H", "8D"]);
    $this->assertEquals($hand->get_hand_rank(), 2);
  }

  public function testGetsHandRankForTwoPair() {
    $hand = new Hand(["AS", "AD", "4C", "4H", "8D"]);
    $this->assertEquals($hand->get_hand_rank(), 3);
  }

  public function testGetsHandRankForThreeOfAKind() {
    $hand = new Hand(["AS", "AD", "AC", "4H", "8D"]);
    $this->assertEquals($hand->get_hand_rank(), 4);
  }

  public function testGetsHandRankForStraight() {
    $hand = new Hand(["2C", "4D", "3S", "6D", "5S"]);
    $this->assertEquals($hand->get_hand_rank(), 5);
  }

  public function testGetsHandRankForFlush() {
    $hand = new Hand(["QC", "4C", "3C", "6C", "TC"]);
    $this->assertEquals($hand->get_hand_rank(), 6);
  }

  public function testGetsHandRankForFullHouse() {
    $hand = new Hand(["AS", "AD", "AC", "4H", "4D"]);
    $this->assertEquals($hand->get_hand_rank(), 7);
  }

  public function testGetsHandRankForFourOfAKind() {
    $hand = new Hand(["AS", "AD", "AC", "AH", "4D"]);
    $this->assertEquals($hand->get_hand_rank(), 8);
  }

  public function testGetsHandRankForStraightFlush() {
    $hand = new Hand(["2C", "4C", "3C", "6C", "5C"]);
    $this->assertEquals($hand->get_hand_rank(), 9);
  }

  public function testPlayerOneWinsWithHighCard() {
    $p1 = new Hand(["AS", "2S", "4C", "6H", "8D"]);
    $p2 = new Hand(["3H", "4D", "5C", "7D", "9H"]);

    $this->assertTrue($p1->is_winner($p2));
  }

  public function testPlayerOneWinsHighCardTie() {
    $p1 = new Hand(["AS", "3S", "4C", "6H", "8D"]);
    $p2 = new Hand(["AS", "2S", "4C", "6H", "8D"]);

    $this->assertTrue($p1->is_winner($p2));
  }

  public function testPlayerOneWinsWithPairTie() {
    $p1 = new Hand(["4D", "6S", "9H", "QH", "QC"]);
    $p2 = new Hand(["3D", "6D", "7H", "QD", "QS"]);

    $this->assertTrue($p1->is_winner($p2));
  }
  
  public function testPlayerOneWinsFullHouseTieWithHigherThreeOfAKind() {
    $p1 = new Hand(["2H", "2D", "4C", "4D", "4S"]);
    $p2 = new Hand(["3C", "3D", "3S", "9S", "9D"]);

    $this->assertTrue($p1->is_winner($p2));
  }
}

?>
