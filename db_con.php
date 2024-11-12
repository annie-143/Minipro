<?php
$connection = new mysqli('localhost', 'root', '', 'petconnect');
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>
