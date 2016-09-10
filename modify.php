<?php
// echo $_POST["content"];
$server = "127.0.0.1";
$user = "Baelyk";
$pass = "tardiscookie";
$database = "wiki";
$connection = mysqli_connect($server, $user, $pass, $database);

if(!$connection) {
    die("Connection failed: " . $connection->connect_error);
} else {
    // echo "Connection succeded!";
}
if( isset( $_POST["create"] ) ) {
    // echo "create";
    $sql = 'INSERT INTO pages (name, content, reason) VALUES ("' . $_POST["page"] . '", "' . htmlspecialchars($_POST["content"]) . '")';
    $redirectInfo = "#created";
} else {
    // echo "update";
    $sql = 'UPDATE pages SET content="'.htmlspecialchars($_POST["content"]).'", reason="' . $_POST["reason"] . '" WHERE name="'.$_POST["page"].'"';
    $redirectInfo = "#updated";
}

if($connection->query($sql) === TRUE) {
    // echo " Success! ";
} else {
    echo " ERROR " . $connection->error;
}

// echo $sql;
header("Location: /wiki/?page=" . $_POST["page"]);
