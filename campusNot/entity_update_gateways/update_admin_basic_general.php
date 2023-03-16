<?php
	include("../security_protocols/admin_master_control.php");
	
    $userID = $_POST["userID"];
    $adminStartYear = $_POST["adminStartYear"];
    $adminEndYear = $_POST["adminEndYear"];
    $adminPermissionsCode = $_POST["adminPermissionsCode"];

    //checks if userID valid
	$stmt = $pdo->prepare("SELECT * FROM user_general WHERE userID = ?");
	$stmt->execute([$userID]);
	$check = $stmt->fetch();
	//inserts to user_general
	if ($check == NULL) {
		echo 'FATAL ERROR';
	} else {
		if ($adminEndYear == NULL || $adminEndYear == "") {
			$adminEndYear = 0;
		} else {
			$adminEndYear = intval($adminEndYear);
		}
        $adminStartYear = intval($adminStartYear);
		$stmt = $pdo->prepare("UPDATE admin_basic_general SET adminStartYear = ?, adminEndYear = ?, adminPermissionsCode = ? WHERE userID = ?");
	    $result = $stmt->execute([$adminStartYear, $adminEndYear, $adminPermissionsCode, $userID]);
        echo 'Update Successful!';
		}
