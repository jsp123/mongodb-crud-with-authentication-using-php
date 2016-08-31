<?php
require_once('inc/config.php');

if( logout() ){
	header('Location: index.php');
}
?>
