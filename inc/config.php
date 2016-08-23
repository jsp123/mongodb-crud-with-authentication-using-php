<?php 
require_once('functions.php');

/* Local Database Connection */
$connection = new MongoClient();
$db = $connection->selectDB('carlofontanos');

/* Live Database Connection 
$conn = new MongoClient('mongodb://admin:pass@ds013206.mlab.com:13206/mongoapp');
$db = $connection->selectDB('mongoapp');
*/