<?php
	include('../security_protocols/admin_check_security.php');
    if($_SESSION["permissionsCode"] != 6554 && $_SESSION["permissionsCode"] != 8383) {
        header("Location: ../index.html");
    }
    $clubID = $_POST["clubID"];
    $isOwner = strval($_POST["isOwner"]);
    $isOrganiser = strval($_POST["isOrganiser"]);
    $userID = "";
	$userName = $_POST["userName"];
	$stmt = $pdo->prepare("SELECT userID FROM user_general WHERE userName = ? AND userStatus = 1");
	$stmt->execute([$userName]);
	$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    foreach($stmt->fetchAll() as $row) {
        $userID .= $row['userID'];
    } 
	$stmt = $pdo->prepare("SELECT userID FROM club_users WHERE clubID = ? AND userID = ?");
	$stmt->execute([$clubID, $userID]);  
	$check5 = $stmt->fetch();  
	if ($check5 != NULL) {
		echo 'This user already in club!';
	} else {
		//check if club exists
		$stmt = $pdo->prepare("SELECT * FROM club_general WHERE clubID = ? AND clubStatus = 1");
		$stmt->execute([$clubID]);
		$check = $stmt->fetch();
		$stmt = $pdo->prepare("SELECT * FROM user_general WHERE userID = ? AND userStatus = 1");
		$stmt->execute([$userID]);
		$check2 = $stmt->fetch();
		$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		//inserts to club_users
		if ($check == NULL) {
			echo 'This club doesn\'t exist!';
		} else if ($check2 == NULL) {
			echo 'This user doesn\'t exist!';
		} else {
			$stmt = $pdo->prepare("SELECT * FROM user_general WHERE userID = ? AND userStatus = 1");
			$stmt->execute([$userID]);
			$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
			foreach($stmt->fetchAll() as $type) {
				if($type['userType'] == 'S') {
					$stmt = $pdo->prepare("SELECT clubRegistrationsStudents, clubMaxStudents FROM club_details WHERE clubID = ?");
					$stmt->execute([$clubID]);
					$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
					foreach($stmt->fetchAll() as $test) {
						if ($test['clubRegistrationsStudents'] == $test['clubMaxStudents']) {
							echo 'Student maximum already reached! Cannot add this participant.';
						} else {
							$stmt = $pdo->prepare('INSERT INTO club_users (clubID, userID, isOwner, isOrganiser) VALUES (?, ?, ?, ?)');
							$result = $stmt->execute([$clubID, $userID, $isOwner, $isOrganiser]);
							$stmt = $pdo->prepare('UPDATE club_details SET clubRegistrationsStudents = clubRegistrationsStudents + 1 WHERE clubID = ?');
							$result = $stmt->execute([$clubID]);
							echo 'Upload Successful!';
						}
					}
				}
				if($type['userType'] == 'P') {
					$stmt = $pdo->prepare("SELECT clubRegistrationProfessors, clubMaxProfessors FROM club_details WHERE clubID = ?");
					$stmt->execute([$clubID]);
					$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
					foreach($stmt->fetchAll() as $test) {
						if ($test['clubRegistrationProfessors'] == $test['clubMaxProfessors']) {
							echo 'Professor maximum already reached! Cannot add this participant.';
						} else {
							$stmt = $pdo->prepare('INSERT INTO club_users (clubID, userID, isOwner, isOrganiser) VALUES (?, ?, ?, ?)');
							$result = $stmt->execute([$clubID, $userID, $isOwner, $isOrganiser]);
							$stmt = $pdo->prepare('UPDATE club_details SET clubRegistrationProfessors = clubRegistrationProfessors + 1 WHERE clubID = ?');
							$result = $stmt->execute([$clubID]);
							echo 'Upload Successful!';
						}
					}
				}
				if($type['userType'] == 'A') {
					echo 'Admins do not join clubs!';
				}
			}
		}
	}