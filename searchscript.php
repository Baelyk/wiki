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
    $search = str_replace("$", "&#36;", $search);
    $search = str_replace('"', "&quot;", $search);
    $search = str_replace("'", "&#39;", $search);
    
    $sql = "SELECT name FROM pages WHERE name LIKE '%" . $search . "%'";
    $results = $connection->query($sql);//->fetch_assoc();
    if( $results->num_rows > 0) {
        echo "<h2>Name Search</h2>";
        while( $row = $results->fetch_assoc() ) {
            echo "<a class='searchresult' href='/wiki/?page=" . $row["name"] . "'>" . $row["name"] . "</a>"; echo "<br />";
        }
    }

    $sql = "SELECT name FROM pages WHERE content LIKE '%" . $search . "%'";
    $results = $connection->query($sql);
    if( $results->num_rows > 0 ) {
        echo "<h2>Content Search</h2>";
        while( $row = $results->fetch_assoc() ) {
            echo "<a class='searchresult' href='/wiki/?page=" . $row["name"] . "'>" . $row["name"] . "</a>"; echo "<br />";
        }
    }

}
