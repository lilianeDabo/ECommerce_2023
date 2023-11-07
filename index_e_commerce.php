<?php
// database credentials
$mysql_host = "localhost";
$mysql_database = "e_commerce";
$mysql_user = "root";
$mysql_password = "";

// database connection string
$db = new PDO("mysql:host=$mysql_host;dbname=$mysql_database", $mysql_user, $mysql_password);

// get data from the SQL file
$query = file_get_contents("scriptEcommerce.sql");

// prepare the SQL statements
$stmt = $db->prepare($query);

// execute the SQL
if ($stmt->execute()){
    echo "Success";
}
else {
    echo "Fail";
}
