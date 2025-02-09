<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "bachelorproef";

//error gehad? Je kan count van particapants id resetten door: ALTER TABLE participants AUTO_INCREMENT = HOOGSTE+1

function create_tables()
{
    global $servername, $username, $password, $dbname;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "CREATE TABLE IF NOT EXISTS `participants` (
                participant_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                gender VARCHAR(255) NOT NULL,
                age INT NOT NULL,
                expertise BOOL NOT NULL,
                colorblind BOOL NOT NULL,
                bad_vision BOOL NOT NULL
                )";

    if ($conn->query($sql) !== TRUE) {
        die("table creation Participants failed: " . $conn->error);
    }

    $sql = "CREATE TABLE IF NOT EXISTS `images` (
                image_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                filename VARCHAR(255) NOT NULL,
                extension VARCHAR(255) NOT NULL,
                path VARCHAR(255) NOT NULL,
                practice_data BOOL NOT NULL,
                chrome_not_safari BOOL NOT NULL,
                filesize INT NOT NULL
                )";

    if ($conn->query($sql) !== TRUE) {
        die("table creation Images failed: " . $conn->error);
    }

    $sql = "CREATE TABLE IF NOT EXISTS `ratings` (
                participant_id INT NOT NULL,
                image_id INT NOT NULL,
                sharpness INT NOT NULL,
                color_contrast INT NOT NULL,
                general INT NOT NULL,
                primary key (participant_id, image_id)
                )";

    if ($conn->query($sql) !== TRUE) {
        die("table creation Ratings failed: " . $conn->error);
    }

    $conn->close();
}

function create_user_and_get_user_id($gender, $age, $expertise, $colorblind, $bad_vision)
{
    global $servername, $username, $password, $dbname;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO participants(gender, age, expertise, colorblind, bad_vision) VALUES ('$gender', '$age', '$expertise', '$colorblind', '$bad_vision')";

    $participant_id = false;

    if ($conn->query($sql) !== TRUE) {
        die("insert user failed: " . $conn->error);
    } else {
        $participant_id = $conn->insert_id;
    }

    $conn->close();
    return $participant_id;
}

function create_image_record($filename, $extension, $path, $practice_data, $chrome_not_safari, $filesize)
{
    global $servername, $username, $password, $dbname;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO images(filename, extension, path, practice_data, chrome_not_safari, filesize) VALUES ('$filename', '$extension', '$path', '$practice_data', '$chrome_not_safari', '$filesize')";

    if ($conn->query($sql) !== TRUE) {
        die("insert image failed: " . $conn->error);
    }

    $conn->close();
}

function delete_tables()
{
    global $servername, $username, $password, $dbname;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DROP TABLE IF EXISTS `participants`";

    if ($conn->query($sql) !== TRUE) {
        die("table deletion Participants failed: " . $conn->error);
    }

    $sql = "DROP TABLE IF EXISTS `images`";

    if ($conn->query($sql) !== TRUE) {
        die("table deletion Images failed: " . $conn->error);
    }

    $sql = "DROP TABLE IF EXISTS `ratings`";

    if ($conn->query($sql) !== TRUE) {
        die("table deletion Ratings failed: " . $conn->error);
    }

    $conn->close();
}

function get_all_images()
{
    global $servername, $username, $password, $dbname;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM images";
    $result = $conn->query($sql);

    $conn->close();
    return $result;
}

function get_all_participants()
{
    global $servername, $username, $password, $dbname;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM participants";
    $result = $conn->query($sql);

    $conn->close();
    return $result;
}

function get_all_ratings()
{
    global $servername, $username, $password, $dbname;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM ratings";
    $result = $conn->query($sql);

    $conn->close();
    return $result;
}

function get_all_user_rated_images($participant_id)
{
    global $servername, $username, $password, $dbname;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM ratings WHERE participant_id=$participant_id";
    $result = $conn->query($sql);

    $conn->close();
    return $result;
}

function add_user_rating($participant_id, $image_id, $sharpness, $color_contrast, $general)
{
    global $servername, $username, $password, $dbname;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO ratings(participant_id, image_id, sharpness, color_contrast, general) VALUES ('$participant_id', '$image_id', '$sharpness', '$color_contrast', '$general')";

    if ($conn->query($sql) !== TRUE) {
        die("insert rating failed: " . $conn->error);
    }

    $conn->close();
}
