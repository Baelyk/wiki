<?php
$pageExists;

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

if( !( isset( $_GET["page"] ) ) ) {
    $page = "select_page"; // Default to select_page if a page is not specified
} else {
    $page = $_GET["page"];
    if( ( isset( $_GET["edit"] ) ) && $_GET["edit"] == "on" ) {
        $edit = TRUE;
    } else {
        $edit = FALSE;
    }
}

function getPage ($p, $c) { // get date from the database based on a page ($p) and the connection ($c)
    global $pageExists;

    $sql = "SELECT content FROM pages WHERE name='$p'";

    $cont = $c->query($sql);
    $cont = $cont->fetch_assoc();

    if( isset( $cont["content"] ) ) {
        // echo "\$cont['content'] is set";
        $pageExists = TRUE;
        return $cont["content"];
    } else {
        // echo "\$cont['content'] is NOT set";
        $pageExists = FALSE;
    }
}

$content = htmlspecialchars_decode(getPage($page, $connection));

if( $edit ) {
    // echo "\$edit is TRUE";
    $display = '
        <form name="edit" id="edit" action="modify.php" method="POST">
            <input type="hidden" value="' . $page . '" name="page"/>
            <textarea name="content" cols="100" rows="30">' . $content . '</textarea> <br />
            Update Reason: <input type="text" value="Minor Edit" name="reason" /><input type="submit" value="Update Page" />
        </form>

    ';
} else {
    // if edit is false:
    $display = shell_exec('/usr/local/bin/node /Users/Baelyk/Documents/Server/wiki/assets/js/markdownify.js "' . $content . '"');

    while($beginBracket = strpos(" " . $display, "[[") > 0) {
        $beginBracket = strpos(" " . $display, "[[");
        $endBracket = strpos(" " . $display, "]]");
        $link = substr($display, $beginBracket + 1, abs($beginBracket - $endBracket) - 2); // add one to display because of the space in strpos and to exlude the brackets

        $sql = "SELECT name FROM pages WHERE name='$link'";

        $linkPage = $connection->query($sql);
        $linkPage = $linkPage->fetch_assoc();

        if( isset( $linkPage["name"] ) ) {
            $link = "<a class='exists' href='?page=" . $link . "'>" . $link . "</a>";
        } else {
            $link = "<a class='noexists' href='?page=" . $link . "'>" . $link . "</a>";
        }
        $display = substr_replace($display, $link, $beginBracket - 1, abs($beginBracket - $endBracket) + 2);
    }
}

if( $pageExists == FALSE ) {
    // echo "\$pageExists is FALSE";
    $display = '
        <h1>The page you are looking for does not exist. You can create it below, or <a href="?page=select_page">select a new page</a>.</h1>
        <form id="edit" action="modify.php" method="POST">
            <input type="hidden" value="' . $page . '" name="page"/>
            <input type="hidden" value="TRUE" name="create"/>
            <textarea name="content" cols="100" rows="30">' . $content . '</textarea> <br />
            <input type="submit" value="Create Page" />
        </form>
    ';
}

// echo $page . " "; // test if $page is working
// echo $_GET["edit"];
if( $page == "select_page" ) {
    echo '
        <div id="modified"></div>

        <script type="text/javascript">
            if(location.hash == "#updated") {
                var modify = document.getElementById("modified");
                modify.innerHTML = "A page was updated. <br /> <br />";
            }
            if(location.hash == "#created") {
                var modify = document.getElementById("modified");
                modify.innerHTML = "A page was created. <br /> <br />";
            }
        </script>
';

}
// echo $pageExists; // 1 if TRUE nothing if FALSE
echo $display;
// echo shell_exec("/usr/local/bin/node /Users/Baelyk/Documents/Server/wiki/assets/js/markdownify.js '" . $content . "'");
