<?php
$sqli = new mysqli("localhost", "root", "root", "bushaltes", 3306);
if ($sqli->connect_error) {
    echo $sqli->connect_error; exit;
}
$stmt = $sqli->prepare("SELECT `address`, `timeRelativeSeconds` FROM `halte`;");
if (!$stmt) {
    echo $sqli->error; exit;
}
$stmt->execute();
$stmt->bind_result($address, $timeRelativeSeconds);

$departure = new DateTime("now", new DateTimeZone("europe/amsterdam"));

var_dump($departure);
$data = [];

while ($stmt->fetch()) {
    // add time
    $departure->setTimestamp($departure->getTimestamp() + $timeRelativeSeconds);

    // store
    array_push($data, [
        "address" => $address,
        "timeRelativeSeconds" => $timeRelativeSeconds,
        "clockTime" => $departure->format("H:i"),
    ]);
}

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
        for ($i = 0; $i < count($data) - 1; $i++) {
            $v = $data[$i];
            echo "<div>" . $v["address"] . "; " . $v["clockTime"] . "</div>";
        }
        $last = $data[count($data) - 1];
        echo "<div style='margin-top: 1em;'>Aankomt eindbestemming:</div>";
        echo "<div>" . $last["address"] . "; " . $last["clockTime"] ."</div>"
        ?>
    </div>
</body>
</html>
