<?php 
/* Local Database Connection */
try {
	$connection = new MongoClient();
	$db = $connection->selectDB('carlofontanos');
	$users = $db->users;
	$products = $db->products;
	
	
} catch ( MongoConnectionException $e ) {
	die('Error connecting to MongoDB server');
	
} catch ( MongoException $e ) {
	die('Error: ' . $e->getMessage());
}

/* Live Database Connection 
$conn = new MongoClient('mongodb://admin:pass@ds013206.mlab.com:13206/mongoapp');
$db = $connection->selectDB('mongoapp');
*/

require_once('functions.php');
require_once('user.php');
require_once('product.php');

session_start();

