<?php
	session_start();
unset($_SESSION['user']);
unset($_SESSION['droits']);
unset($_SESSION['autorisation']);
	session_unset();
	header('Location: ../index.html');