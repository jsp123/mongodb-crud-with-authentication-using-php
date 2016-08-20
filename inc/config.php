<?php 
require_once('functions.php');

// $conn = new MongoClient();
$conn = new MongoClient('mongodb://admin:pass@ds013206.mlab.com:13206/mongoapp');
$db = $conn->selectDB('mongoapp');