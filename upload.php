<?php
    if( isset( $_POST["uploadSubmit"] ) ) {
        date_default_timezone_set("America/Chicago");
        $now = date(DATE_ATOM);

        $doUpload = TRUE;
        $failReason = "";
        $uploadDir = "assets/img/uploads/";
        $uploadFile = $uploadDir . basename($_FILES["upload"]["name"]);
        $uploadType = pathinfo($uploadFile, PATHINFO_EXTENSION);

        $isReal = getimagesize($_FILES["upload"]["tmp_name"]);
        if( $isReal === FALSE ) {
            $doUpload = FALSE;
            $failReason .= "Not a real image.<br />";
        }

        if( file_exists( $uploadFile ) ) {
            $doUpload = FALSE;
            $failReason .= "File already exists.<br />";
        }

        if($uploadType != "jpg" && $uploadType != "png" && $uploadType != "jpeg" && $uploadType != "gif" ) {
            $doUpload = FALSE;
            $failReason .= "Only .jpg, .jpeg, .png, and .gif are allowed.<br />";
        }

        if( $doUpload ) {
            if( move_uploaded_file($_FILES["upload"]["tmp_name"], $uploadFile) ) {
                echo "File Uploaded!";

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
                
                $id = $_POST["id"];
                $name = $_POST["name"];
                $alt = $_POST["alt"];
                $description = $_POST["description"];

                $id = str_replace("$", "&#36;", $id);
                $id = str_replace('"', "&quot;", $id);
                $id = str_replace("'", "&#39;", $id);
                $name = str_replace("$", "&#36;", $name);
                $name = str_replace('"', "&quot;", $name);
                $name = str_replace("'", "&#39;", $name);
                $alt = str_replace("$", "&#36;", $alt);
                $alt = str_replace('"', "&quot;", $alt);
                $alt = str_replace("'", "&#39;", $alt);
                $description = str_replace("$", "&#36;", $description);
                $description = str_replace('"', "&quot;", $description);
                $description = str_replace("'", "&#39;", $description);

                $sql = "INSERT INTO uploads (name, readName, description, altText, location, uploadDate) VALUES ('" . $id . "', '" . $name . "', '" . $description . "', '" . $alt . "', '" . $uploadFile . "', '" . $now . "')";

                if($connection->query($sql) === TRUE) {
                    echo "Success!<br />";
                } else {
                    echo "<br />ERROR " . $connection->error;
                }

            } else {
                echo "File Upload failed :(";
            }
        } else {
            echo $failReason;
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Upload File</title>
    </head>
    <body>
        <form class="upload" action="upload.php" method="post" enctype="multipart/form-data">
            Image ID: <input type="text" name="id" value="" /> <br />
            Image Name: <input type="text" name="name" value="" /><br />
            Alt text: <input type="text" name="alt" value="" /><br />
            Description:<br />
            <textarea name="description" rows="8" cols="40"></textarea><br />
            <input type="file" name="upload" value="" />
            <input type="submit" name="uploadSubmit" value="Upload">
        </form>
    </body>
</html>
