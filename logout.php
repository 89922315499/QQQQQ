<?php

require "access.php"; 

unset($_SESSION['logged_user']);

header('Location: /');

?>