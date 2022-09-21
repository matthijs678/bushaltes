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

$data = [];
while ($stmt->fetch()) {
    array_push($data, ["address" => $address, "timeRelativeSeconds" => $timeRelativeSeconds]);
}
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
        foreach ($data as $v) {
            echo "<div>" . $v["address"] . "; " . $v["timeRelativeSeconds"] . "</div>";
        }
        ?>
    </div>
</body>
</html>
