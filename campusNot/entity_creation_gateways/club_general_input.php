<?php
    include("../security_protocols/admin_check_security.php");
	if($_SESSION["permissionsCode"] != 6554 && $_SESSION["permissionsCode"] != 8383) {
        header("Location: ../index.html");
    }

    $clubID = uniqid();
    $clubName = $_POST["clubName"];
    $clubStatus = 1;
  
    //check if clubName exists
	$stmt = $pdo->prepare("SELECT * FROM club_general WHERE clubName = ?");
	$stmt->execute([$clubName]);
	$check = $stmt->fetch();
	
	//inserts to club_general
	if ($check != NULL) {
		echo 'Club Name already taken!';
	} else {
		$stmt = $pdo->prepare('INSERT INTO club_general (clubID, clubName, clubStatus) VALUES (?, ?, ?)');
		$result = $stmt->execute([$clubID, $clubName, $clubStatus]);
		$stmt = $pdo->prepare('INSERT INTO club_details (clubID, clubRegistrationsStudents, clubRegistrationProfessors) VALUES (?, 0, 0)');
		$result = $stmt->execute([$clubID]);
		$stmt = $pdo->prepare('INSERT INTO club_schedule (clubID) VALUES (?)');
		$result = $stmt->execute([$clubID]);
        echo 'Upload Successful!';
	}