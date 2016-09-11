<?php
if( isset($_GET["id"] ) ) {
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

    $id = $_GET["id"];

    $id = str_replace("$", "&#36;", $id);
    $id = str_replace('"', "&quot;", $id);
    $id = str_replace("'", "&#39;", $id);

    $sql = "SELECT readName, description, altText, location, uploadDate FROM uploads WHERE name='" . $id . "'";

    if( $file = $connection->query($sql) ) {
        if( $file->num_rows > 0 ) {
            $file = $file->fetch_assoc();
            $description = isset( $file["description"] ) ? $file["description"] : ( isset( $file["altText"] ) ? $file["altText"] : "N/A");
            $date = isset( $file["uploadDate"] ) ? $file["uploadDate"] : "N/A";
            echo "<h2>" . $file["readName"] . "</h2>";
            echo "<img src='" . $file["location"] . "' alt='" . $file["altText"] . "' />";
            echo "<p class='description'><b>Description:</b><br />$description</p>";
            echo "<p class='date'><b>Date:</b> $date</p>";
        } else {
            echo "nope";
        }
    }
} else {
    echo '
    <form class="viewform" action="view.php" method="get">
        Image ID: <input type="text" name="id" value="" /> <br />
        <input type="submit" name="view" value="View">
    </form>
    ';
}
