<?php
$search = $_GET["search"];

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
if( isset( $search ) ) {
    $sql = "SELECT name FROM pages WHERE name='$search'";
    $results = $connection->query($sql)->fetch_assoc();
    if( isset( $results ) ) {
        header("Location: /wiki/index.php?page=" . $search);
    } else {
        echo "Page not found.";
    }
}
