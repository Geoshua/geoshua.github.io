<?php
	include("../security_protocols/admin_master_control.php");
	$userID = uniqid();
	$userPersonalName = $_POST["firstName"] . " " . $_POST["middleName"] . " " . $_POST["lastName"];
	$userName = strtolower(substr($_POST["firstName"], 0, 1)) . strtolower(substr($_POST["lastName"], 0, 12));
	//create userName
	$stmt = $pdo->prepare("SELECT userName FROM user_general WHERE userName LIKE ?");
    $stmt->execute([$userName . "%"]);
	$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

	$count = 0;
	$charArr;
	foreach($stmt->fetchAll() as $verify) {
		if($userName == $verify["userName"]){
			$count++;
		} else {
			$charArr = str_split($verify["userName"]);
			if (is_numeric($charArr[strlen($userName)])) {
				$count++;
			}
		}
	}
	if ($count != 0) {
		$userName .= strval($count + 1);
	}
	//end of create userName*/
	$userPassword = password_hash($userName . date("Y") , PASSWORD_DEFAULT);
	$userType = $_POST["userType"];
	$userEmail = $userName . "@jacobs-university.de";
	$userStatus = true;
	
	
	//checks if username still in table
	$stmt = $pdo->prepare("SELECT * FROM user_general WHERE userName = ?");
	$stmt->execute([$userName]);
	$check = $stmt->fetch();

	//inserts to user_general
	if ($check != NULL) {
		echo 'Unique Username generation failed. (logic error)';
	} else {
		if ($userType == 'A') {
			$adminYearStart = date("Y");
			$stmt = $pdo->prepare('INSERT INTO user_general (userID, userName, userPersonalName, userPassword, userEmail, userType, userStatus) VALUES (?, ?, ?, ?, ?, ?, ?)');
			$result = $stmt->execute([$userID, $userName, $userPersonalName, $userPassword, $userEmail, $userType, $userStatus]);
			$stmt = $pdo->prepare('INSERT INTO admin_basic_general (userID, adminStartYear, adminEndYear, adminPermissionsCode) VALUES (?, ?, NULL, NULL)');
			$result = $stmt->execute([$userID, $adminYearStart]);
			echo 'Admin Upload Successful!';
		}
		if ($userType == 'P') {
			$profStartYear = date("Y");
			$stmt = $pdo->prepare('INSERT INTO user_general (userID, userName, userPersonalName, userPassword, userEmail, userType, userStatus) VALUES (?, ?, ?, ?, ?, ?, ?)');
			$result = $stmt->execute([$userID, $userName, $userPersonalName, $userPassword, $userEmail, $userType, $userStatus]);
			$stmt = $pdo->prepare('INSERT INTO professor_general (userID, profStartYear, profEndYear, profFocusArea) VALUES (?, ?, NULL, NULL)');
			$result = $stmt->execute([$userID, $profStartYear]);
			echo 'Professor Upload Successful!';
		}
		if ($userType == 'S') {
			$stmt = $pdo->prepare('INSERT INTO user_general (userID, userName, userPersonalName, userPassword, userEmail, userType, userStatus) VALUES (?, ?, ?, ?, ?, ?, ?)');
			$result = $stmt->execute([$userID, $userName, $userPersonalName, $userPassword, $userEmail, $userType, $userStatus]);
			$stmt = $pdo->prepare('INSERT INTO student_details_faculty (userID) VALUES (?)');
			$result = $stmt->execute([$userID]);
			$stmt = $pdo->prepare('INSERT INTO student_details_financial (userID) VALUES (?)');
			$result = $stmt->execute([$userID]);
			$stmt = $pdo->prepare('INSERT INTO student_details_health (userID) VALUES (?)');
			$result = $stmt->execute([$userID]);
			$stmt = $pdo->prepare('INSERT INTO student_details_housing (userID) VALUES (?)');
			$result = $stmt->execute([$userID]);
			$stmt = $pdo->prepare('INSERT INTO student_general (userID) VALUES (?)');
			$result = $stmt->execute([$userID]);
			$stmt = $pdo->prepare('INSERT INTO student_details_personal (userID) VALUES (?)');
			$result = $stmt->execute([$userID]);
			echo 'Student Upload Successful!';
		}
	}
