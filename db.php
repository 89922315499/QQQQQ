<?php 

require "libs/rb.php";
require "config.php"; 

R::setup('mysql:host=localhost; dbname=registered_users', "root", "");

session_start();

?>