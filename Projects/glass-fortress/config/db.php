<?php
define('BASE_URL', 'http://localhost/projects/glass-fortress/');

use Dom\Mysql;

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'glass_db');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection has been failed :(" . $conn->connect_error);
}

// echo 'Database has been worked successfully!';
//
// 'Our CEO does not have an account in the database , i will remind him of that later' 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>
    <?php $my_string = "Our CEO does not have an account in the database , i will remind him of that later"; ?>

    <input type="hidden" value="<?php echo $my_string; ?>">
</body>

</html>