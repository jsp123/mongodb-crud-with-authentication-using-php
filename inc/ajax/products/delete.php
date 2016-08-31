<?php
require_once('../../config.php');

if( isset( $_POST['item_id'] ) ){
	echo delete_product( $_POST['item_id'] ) ? 1 : 0;
} else {
	echo 0;
}