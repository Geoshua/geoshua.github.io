<?php
	include('../security_protocols/admin_check_security.php');
    if($_SESSION["permissionsCode"] != 6554 && $_SESSION["permissionsCode"] != 8383) {
        header("Location: ../index.html");
    }
    $clubID = $_POST["clubID"];
    $userID = $_POST["userID"];

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
		$stmt = $pdo->prepare("SELECT userType FROM user_general WHERE userID = ? AND userStatus = 1");
		$stmt->execute([$userID]);
		$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if ($stmt == NULL) {
            echo 'User no longer in club!';
        } else {
            foreach($stmt->fetchAll() as $type) {
                if($type['userType'] == 'S') {
                    $stmt = $pdo->prepare("UPDATE club_details SET clubRegistrationsStudents = clubRegistrationsStudents-1 WHERE clubID = ?");
                    $stmt->execute([$clubID]);
                    echo 'Remove successful!';
                }
                if($type['userType'] == 'P') {
                    $stmt = $pdo->prepare("UPDATE club_details SET clubRegistrationProfessors = clubRegistrationProfessors-1 WHERE clubID = ?");
                    $stmt->execute([$clubID]);
                    echo 'Remove successful!';
                }
            }
            $stmt = $pdo->prepare("DELETE FROM club_users WHERE userID = ? AND clubID = ?");
            $stmt->execute([$userID, $clubID]);
        }
	}
