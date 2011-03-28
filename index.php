<?php
	session_start();
	require('config.php');
	require('classes.php');
        if(isset($_GET['ajx'])) {
		SQL::idleping();
        	SQL::getChat();
                exit;
	}
	require('head.php');
	require('body.php');
	require('footer.php');
?>
