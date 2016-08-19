<?php 
require_once('functions.php');

$conn = new MongoClient();
$db = $conn->selectDB('carlofontanos');