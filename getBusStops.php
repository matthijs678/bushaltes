<?php
// sql: init
$sqli = new mysqli("localhost", "root", "root", "bushaltes", 3306);
if ($sqli->connect_error) {
    exit;
}

// sql: bus
$stmt = $sqli->prepare("SELECT `cycleSeconds`, `cycleOffsetSeconds` FROM `bus`;");
if (!$stmt) {
    exit;
}
$stmt->execute();
$stmt->bind_result($cycleSeconds, $cycleOffsetSeconds);
if (!$stmt->fetch()) {
    exit;
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
    exit;
}
$stmt->execute();
$stmt->bind_result($address, $timeRelativeSeconds);

// get times data (start at next stop)
$now = (new DateTime("now", $dateTimeZone))->getTimestamp();
$times = [];
$last;
while ($stmt->fetch()) {
    // add time
    $timestamp = $departure->getTimestamp() + $timeRelativeSeconds;
    $departure->setTimestamp($timestamp);

    $stop = [
        "address" => $address,
        "timeRelativeSeconds" => $timeRelativeSeconds,
        "clockTime" => $departure->format("H:i"),
    ];
    $last = $stop;

    // passed this stop?
    if ($timestamp < $now) {
        continue;
    }
    
    // store
    array_push($times, $stop);
}

// close
$stmt->close();
$sqli->close();

// return
echo json_encode([
    "times" => $times,
    "last" => $last,
]);
