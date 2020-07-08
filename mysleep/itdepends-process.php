<?php
require_once('utilities.php');
session_start();
require_once('connectdb.php');
$classId = $_SESSION['classId'];
$studentIdList = getUserIdsInClass($classId);
$userId= $_SESSION['userId'];


$session = $_POST['session'];
$resultRow = $_POST['resultRow'];
// include 'connectdb.php';
function getPlayers($contributors, $userId){
  $playerNumber = count($contributors);
  $myRound = array_search($userId,$contributors); // number
  $players = range(0, $playerNumber-1);
  array_splice($players, $myRound, 1);
  $playersID = $contributors;
  $playersName = [];
  foreach ($contributors as $key => $contributor) {
    array_push($playersName, getUserFirstNames($contributor));
  }
  array_splice($playersID, $myRound, 1);
  return array(
    'myRound' => $myRound,
    'playerNumber' => $playerNumber,
    'players' => $players,
    'playersID' => $playersID,
    'playersName' => $playersName
  );
}
function array_search_partial($arr, $keyword) {
    foreach($arr as $index => $string) {
        if (strpos($string, $keyword) !== FALSE)
            return $index;
    }
    return false;
}
// waiting session
if ($session == 'waiting') {
  $result = mysql_query("SELECT * FROM dependCardGame WHERE resultRow=$resultRow");
  $numRow = mysql_num_rows ($result);
  if ($numRow>0) {
    $row = mysql_fetch_array($result);
    $round = $row['rounds'];
    $submit = filter_var($row['submit'], FILTER_VALIDATE_BOOLEAN);
    $winner = $row['winner'];
    $winnerName = getUserFirstNames($winner);

    // find my round
    $contributors = explode(',',$row['contributors']);
    $playersResult = getPlayers($contributors, $userId);

    $playerNumber = $playersResult['playerNumber'];
    $myRound = $playersResult['myRound']; // number
    $players = $playersResult['players'];
    $playersID = $playersResult['playersID'];
    $playersName = $playersResult['playersName'];

    $newDV = explode(',',$row['newDVpool']);
    $usedDV = explode(',',$row['usedDVpool']);
    $myIV = explode(',',$row['iv'.($myRound+1)]);
    $myPairs = explode(',',$row['pair'.($myRound+1)]);

    // alloc other players cards
    $IVA = [];
    $IVB = [];
    $IVC = [];
    $pairA = [];
    $pairB = [];
    $pairC = [];
    if ($playerNumber>1) {
      $IVA = explode(',',$row['iv'.($players[0]+1)]);
      $pairA = explode(',',$row['pair'.($players[0]+1)]);
    }
    if ($playerNumber>2) {
      $IVB = explode(',',$row['iv'.($players[1]+1)]);
      $pairB = explode(',',$row['pair'.($players[1]+1)]);
    }
    if ($playerNumber>3) {
      $IVC = explode(',',$row['iv'.($players[2]+1)]);
      $pairC = explode(',',$row['pair'.($players[2]+1)]);
    }

    echo json_encode(
        array(
          "round" => $round,
          "myRound" => $myRound,
          "players" => $players,
          "playersID" => $playersID,
          "playersName" => $playersName,
          "allPlayer" => $contributors,
          "newDV" => array_filter($newDV),
          "usedDV" => array_filter($usedDV),
          "myIVCard" => array_filter($myIV),
          "myPairs" => array_filter($myPairs),
          "playerAIVCard" => array_filter($IVA),
          "playerBIVCard" => array_filter($IVB),
          "playerCIVCard" => array_filter($IVC),
          "playerAPairs" => array_filter($pairA),
          "playerBPairs" => array_filter($pairB),
          "playerCPairs" => array_filter($pairC),
          "myID" => $userId,
          "submit" => $submit,
          "winner" => $winner,
          "winnerName" => $winnerName
        )
    );
  }
} elseif ($session == 'playing') {
  $myRound = $_POST['myRound'];
  $myPairsKey = 'pair'.($myRound+1);
  $myPairsValue = $_POST['myPairs'];
  $myDVs = $_POST['myDVs'];
  $winner = $_POST['winner'];

  // update round
  $result = mysql_query("SELECT * FROM dependCardGame WHERE resultRow=$resultRow");
  $row = mysql_fetch_array($result);
  $currentRound = $row['rounds'];
  $contributors = explode(',',$row['contributors']);
  $playersResult = getPlayers($contributors, $userId);
  $playerNumber = $playersResult['playerNumber'];
  $players = $playersResult['players'];
  $nextRound = ($currentRound+1) % $playerNumber;

  // remove paired cards from pools
  $newDV = array_filter(explode(',',$row['newDVpool']));
  $usedDV = array_filter(explode(',',$row['usedDVpool']));
  foreach ($myDVs as $DVkey => $DVvalue) {
    if (($key = array_search($DVvalue, $newDV)) !== false) {
        unset($newDV[$key]);
    }
    if (($key = array_search($DVvalue, $usedDV)) !== false) {
        unset($usedDV[$key]);
    }
  }
  // remove paired cards from other players (only remove, cannot add dv to other players' cards)
  $pairA = [];
  $pairB = [];
  $pairC = [];
  $pairAKey = '';
  $pairBKey = '';
  $pairCKey = '';
  if ($playerNumber>1) {
    $pairA = array_filter(explode(',',$row['pair'.($players[0]+1)]));
    $pairAKey = 'pair'.($players[0]+1);
  }
  if ($playerNumber>2) {
    $pairB = array_filter(explode(',',$row['pair'.($players[1]+1)]));
    $pairBKey = 'pair'.($players[1]+1);
  }
  if ($playerNumber>3) {
    $pairC = array_filter(explode(',',$row['pair'.($players[2]+1)]));
    $pairCKey = 'pair'.($players[2]+1);
  }

  foreach ($myDVs as $DVkey => $DVvalue) {
    if (($key = array_search_partial($pairA, $DVvalue)) !== false) {
        unset($pairA[$key]);
    }
    if (($key = array_search_partial($pairB, $DVvalue)) !== false) {
        unset($pairB[$key]);
    }
    if (($key = array_search_partial($pairC, $DVvalue)) !== false) {
        unset($pairC[$key]);
    }
  }
  $pairA = implode(',',$pairA);
  $pairB = implode(',',$pairB);
  $pairC = implode(',',$pairC);
  $paircQuery = '';
  $pairbQuery = '';
  $paircQuery = '';
  if ($playerNumber>1) {
    $pairaQuery = $pairAKey." = '".$pairA."',";
  }
  if ($playerNumber>2) {
    $pairbQuery = $pairBKey." = '".$pairB."',";
  }
  if ($playerNumber>3) {
    $paircQuery = $pairCKey." = '".$pairC."',";
  }

  // return the no longer used dv back to used pool
  $myCurrentPairs = array_filter(explode(',',$row[$myPairsKey]));
  foreach ($myCurrentPairs as $key => $currentPair) {
    $pair = array_filter(explode('++',$currentPair));
    $previousPairDV = $pair[1];
    if (in_array($previousPairDV,$myDVs) == false) {
      array_push($usedDV, $previousPairDV);
    }
  }
  $newDV = implode(',',$newDV);
  $usedDV = implode(',',$usedDV);
  // , $pairAKey = '$pairA', $pairBKey = '$pairB', $pairCKey = '$pairC'
  if ($winner==1) {
    $update_query = "UPDATE dependCardGame SET $myPairsKey = '$myPairsValue', ".$pairaQuery.$pairbQuery.$paircQuery." newDVpool = '$newDV', usedDVpool = '$usedDV', rounds = $nextRound, submit=1, winner=$userId WHERE resultRow = $resultRow";
  }else {
    $update_query = "UPDATE dependCardGame SET $myPairsKey = '$myPairsValue', ".$pairaQuery.$pairbQuery.$paircQuery." newDVpool = '$newDV', usedDVpool = '$usedDV', rounds = $nextRound WHERE resultRow = $resultRow";
  }

  $result = mysql_query($update_query);
  echo json_encode(
      array(
        "success" => $pairAKey,
        "current" => $pairBKey,
        "players" => $result2,
        "myPairs" => $players,
        "pairKey" => $result
      )
  );
  // $result = mysql_query("SELECT * FROM dependCardGame WHERE resultRow=$resultRow");
} elseif ($session == 'skip') {
  // update round
  $result = mysql_query("SELECT * FROM dependCardGame WHERE resultRow=$resultRow");
  $row = mysql_fetch_array($result);
  $currentRound = $row['rounds'];
  $contributors = explode(',',$row['contributors']);
  $playerNumber = count($contributors);
  $nextRound = ($currentRound+1) % $playerNumber;
  // move new card to used card
  $newDV = array_filter(explode(',',$row['newDVpool']));
  $usedDV = array_filter(explode(',',$row['usedDVpool']));
  $thisDV = $newDV[0];
  unset($newDV[0]);
  array_push($usedDV, $thisDV);
  $newDV = implode(',',$newDV);
  $usedDV = implode(',',$usedDV);

  $update_query = "UPDATE dependCardGame SET rounds = $nextRound, newDVpool = '$newDV', usedDVpool = '$usedDV' WHERE resultRow = $resultRow";
  $result = mysql_query($update_query);
  echo json_encode(
      array(
        "success" => $result,
        "new" => $newDV,
        "used" => $usedDV
      )
  );
  // $result = mysql_query("SELECT * FROM dependCardGame WHERE resultRow=$resultRow");
} else {
  echo "error";
}
?>
