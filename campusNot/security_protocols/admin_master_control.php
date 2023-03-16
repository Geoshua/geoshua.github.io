<?php
	include("admin_check_security.php");
    if($_SESSION["permissionsCode"] != 8383) {
        header("Location: ../index.html");
    }
?>