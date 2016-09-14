<?php
if( isset( $_POST["page"] ) ) {
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

    $sql = "SELECT id, name, content, dateVersion FROM pagesversions WHERE name='" . $_POST["page"] . "'";
    $results = $connection->query($sql);//->fetch_assoc();
    if( $results->num_rows > 0) {
        echo "<h2>Page Versions for " . $_POST["page"] . "</h2>";
        while( $row = $results->fetch_assoc() ) {
            echo '
            <div class="pageversions">
                <b>' . $row["name"] . '</b> | <span class="date">' . $row["dateVersion"] . '</span> <br />
                <div class="content">
                    ' . substr($row["content"], 0, 50) . ' ...
                </div>
                <a href="versions.php?vpage=' . $row["id"] . '">View full page</a>
                <br /><br /><hr /><br />
            </div>
            ';
        }
    } else {
        echo "<h2>No page versions found :(</h2>";
    }

} else {
    echo '
        <form class="versionform" action="versions.php" method="post">
            <input type="text" name="page" value="" />
            <input type="submit" name="version" value="Find Versions" />
        </form>
    ';

}
