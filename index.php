<?php
// sql: init
$sqli = new mysqli("localhost", "root", "root", "bushaltes", 3306);
if ($sqli->connect_error) {
    echo $sqli->connect_error; exit;
}

// sql: bus
$stmt = $sqli->prepare("SELECT `cycleSeconds`, `cycleOffsetSeconds` FROM `bus`;");
if (!$stmt) {
    echo $sqli->error; exit;
}
$stmt->execute();
$stmt->bind_result($cycleSeconds, $cycleOffsetSeconds);
if (!$stmt->fetch()) {
    echo "there is no bus"; exit;
}
$stmt->close();

// start at start of current cycle
$dateTimeZone = new DateTimeZone("europe/amsterdam");
$departure = new DateTime("now", $dateTimeZone);
$secondsNow =
    ((int) $departure->format("H")) * 3600
    + ((int) $departure->format("i")) * 60
    + ((int) $departure->format("s"));
$departure->setTime(0, 0, $secondsNow - $secondsNow % $cycleSeconds, 0);

// sql: haltes
$stmt = $sqli->prepare("SELECT `address`, `timeRelativeSeconds` FROM `halte`;");
if (!$stmt) {
    echo $sqli->error; exit;
}
$stmt->execute();
$stmt->bind_result($address, $timeRelativeSeconds);

// get times data (start at next stop)
$now = (new DateTime("now", $dateTimeZone))->getTimestamp();
$times = [];
while ($stmt->fetch()) {
    // add time
    $timestamp = $departure->getTimestamp() + $timeRelativeSeconds;
    $departure->setTimestamp($timestamp);

    // passed this stop?
    if ($timestamp < $now) {
        continue;
    }
    
    // store
    array_push($times, [
        "address" => $address,
        "timeRelativeSeconds" => $timeRelativeSeconds,
        "clockTime" => $departure->format("H:i"),
    ]);
}

// close
$stmt->close();
$sqli->close();

header("Refresh:20");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div style="display: flex; flex-direction: column; width: 40ch;">
        <?php
        for ($i = 0; $i < count($times) - 1; $i++) {
            $v = $times[$i];
            echo "<div>" . $v["address"] . "; " . $v["clockTime"] . "</div>";
        }
        echo "<div style='margin-top: 1em;'>Aankomt eindbestemming:</div>";
        $last = $times[count($times) - 1];
        if ($last) {
            echo "<div>" . $last["address"] . "; " . $last["clockTime"] ."</div>";
        }
        else {
            echo "<div>Einde bereikt</div>";
        }
        ?>
    </div>
</body>
</html>
