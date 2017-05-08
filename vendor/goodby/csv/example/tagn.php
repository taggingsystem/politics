<?php
session_start();
include_once "connection.php";
include_once "classes/tweets.php";

$tweet = new Tweets($DB_con, $_SESSION["id"]);
$tweet->setTag('N');
$tweet->update($_SESSION["id"]);
header("Location: index.php")
?>

