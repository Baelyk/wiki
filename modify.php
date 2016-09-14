<?php
date_default_timezone_set("America/Chicago");
$now = date(DATE_ATOM);

// echo $_POST["content"];
$server = "127.0.0.1";
$user = "Baelyk";
$pass = "tardiscookie";
$database = "wiki";
$connection = mysqli_connect($server, $user, $pass, $database);

$content = $_POST["content"];
$reason = $_POST["reason"];

$content = str_replace("$", "&#36;", $content);
$content = str_replace('"', "&quot;", $content);
$content = str_replace("'", "&#39;", $content);
$reason = str_replace("$", "&#36;", $reason);
$reason = str_replace('"', "&quot;", $reason);
$reason = str_replace("'", "&#39;", $reason);

if(!$connection) {
    die("Connection failed: " . $connection->connect_error);
} else {
    // echo "Connection succeded!";
}
if( isset( $_POST["create"] ) ) {
    // echo "create";
    $sql = 'INSERT INTO pages (name, content, dateCreated, dateLastUpdated) VALUES ("' . $_POST["page"] . '", "' . htmlspecialchars($content) . '", "' . $now . '", "' . $now . '")';
    $redirectInfo = "#created";
} else {
    // echo "update";
    $sql = 'UPDATE pages SET content="'.htmlspecialchars($content).'", reason="' . $reason . '", dateLastUpdated="' . $now . '" WHERE name="'.$_POST["page"].'"';
    $sql = "INSERT INTO pagesversions (name, content, dateVersion, reason) VALUES ('" . $_POST["page"] . "', '" . htmlspecialchars($content) . "', '$now', '$reason')";
    $redirectInfo = "#updated";
}

if($connection->query($sql) === TRUE) {
    // echo " Success! ";
} else {
    echo " ERROR " . $connection->error;
}

// echo $sql;
header("Location: /wiki/?page=" . $_POST["page"]);
