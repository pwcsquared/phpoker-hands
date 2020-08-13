<?php
declare(strict_types=1);

include __DIR__ . "/Hand.php";

$file = fopen("p054_poker.txt", "r");
$playerOneWins = 0;

if ($file) {
  while (($line = fgets($file, 4096)) !== false) {
     $hands = explode(" ", $line);
     $playerOne = new Hand(array_slice($hands, 0, 5));
     $playerTwo = new Hand(array_slice($hands, 5));

     if ($playerOne->is_winner($playerTwo)) {
       $playerOneWins++;
     }
  }

  echo "Player One won $playerOneWins hands.";
  fclose($file);
}

?>
