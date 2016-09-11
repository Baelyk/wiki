<?php
    $edit = $_GET["edit"] == "on" ? TRUE : FALSE; // define edit and page as to not keep making get requests
    $page = $_GET["page"];
    $pageNullProtect = isset( $_GET["page"] ) ? $_GET["page"] : "select_page";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link id="maincss" rel="stylesheet" href="assets/css/stylesheet.css" media="screen" title="no title">
        <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css" media="screen" title="no title">
        <title>Wiki</title>
    </head>
    <body>
        <header>
            <div id="wikiheader" class="wikiheader">
                <div id="wikilogo" class="wikilogo"></div>
                <div id="header" class="header">
                    <span id="wikiname" class="wikiname">Wiki Name</span> <br />
                    <span id="wikidescription" class="wikidescription">Wiki Description</span>
                </div>
            </div>
            <div id="controlbar" class="controlbar">
                <span id="read" class="read"><button <?php echo (!$edit ? "disabled" : "") ?> type="button" name="read" onclick=<?php echo ( isset( $page ) ? "window.location='/wiki/?page=" . $page . "'" : "" ); ?>><i class="fa fa-file-o" aria-hidden="true"></i></button></span>
                <span id="edit" class="edit"><button <?php echo ($edit ? "disabled" : "") ?> type="button" name="edit" onclick=<?php echo (isset( $page ) ? "location.href='/wiki/?page=" . $page . "&edit=on'" : "'location.href=/wiki/?page=select_page&edit=on'"); ?>><i class="fa fa-pencil" aria-hidden="true"></i></button></span>
                <span id="print" class="print"><button type="button" name="print" onclick=<?php echo (isset( $page ) ? "location.href='/wiki/print.php?page=" . $page . "'": "'location.href=/wiki/print.php?page=select_page'"); ?>><i class="fa fa-print" aria-hidden="true"></i></button></span>
            </div>
        </header>

        <div id="sidebar" class="sidebar">
            <a href="?page=main"><?php echo ( $page == "main" ? "<b>Main Page</b>" : "Main Page") ?></a>
            <hr />
            <a href=<?php echo "?page=" . $pageNullProtect ?>>Read Page</a>
            <a href=<?php echo "?page=" . $pageNullProtect . "&edit=on"; ?>>Edit Page</a>
            <a href=<?php echo "print.php?page=" . $pageNullProtect ?>>Print Page</a>
            <hr />
            <a href="upload.php">Upload Image</a>
            <a href="view.php">View Image</a>
            <hr />
            <a href="/wiki/?page=createpage">Create Page</a>
            <hr />
            <form class="search" action="/wiki/search.php" method="get">
                <input id="search" class="search" type="text" name="search" value="Search..." />
                <input type="submit" name="searchsubmit" value="Go">
            </form>
        </div>

        <!-- WIKI CONTENT BEGIN ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->

        <div id="wikicontent" class="wikicontent">
                <?php include("page.php"); //output the page ?>
        </div>

        <!-- WIKI CONTENT END ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->

        <footer>

        </footer>
    </body>
    <script src="assets/config/config.json" charset="utf-8"></script>
    <script src="assets/js/markdown-it.js" charset="utf-8"></script>
    <script type="text/javascript">
        // var header = document.getElementById("header");
        var wikilogo = document.getElementById("wikilogo");
        var wikiname = document.getElementById("wikiname");
        var wikidescription = document.getElementById("wikidescription");
        var search = document.getElementById("search");
        var wikicontent = document.getElementById("wikicontent");
        // var footer = document.getElementById("footer");

        wikilogo.innerHTML = "<img src=" + config.wiki.logo.src + " alt=" + config.wiki.logo.alttext + " />";
        wikiname.innerHTML = config.wiki.name;
        wikidescription.innerHTML = config.wiki.description;
        search.addEventListener("focus", function () {
            if (this.value == "Search...") {
                this.value = "";
            }
        }, false);
        search.addEventListener("blur", function () {
            if (!this.value) {
                this.value = "Search...";
                this.className = "search";
            } else {
                this.className = "search-filled";
            }
        }, false);
    </script>
</html>
