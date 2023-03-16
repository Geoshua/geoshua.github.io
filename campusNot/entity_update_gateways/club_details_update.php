<?php
    include("../security_protocols/admin_check_security.php");
    if($_SESSION["permissionsCode"] != 6554 && $_SESSION["permissionsCode"] != 8383) {
        header("Location: ../index.html");
    }

	$clubID = $_POST["clubID"];
	$clubFunding = $_POST["clubFunding"];
	$clubMaxStudents = $_POST["clubMaxStudents"];
	$clubMaxProfessors = $_POST["clubMaxProfessors"];
	$clubLocation = $_POST["clubLocation"];
	$clubDescription = $_POST["clubDescription"];
	$clubMentions = $_POST["clubMentions"];

	//check if clubName exists
	$stmt = $pdo->prepare("SELECT * FROM club_general WHERE clubID = ?");
	$stmt->execute([$clubID]);
	$check1 = $stmt->fetch();

	//inserts to club_details
	if ($check1 == NULL) {
		echo 'This club doesn\'t exist!';
	} else {
		$clubID = $check1['clubID'];
		$stmt = $pdo->prepare('UPDATE club_details SET clubFunding = ?, clubMaxStudents = ?, clubMaxProfessors = ?, clubLocation = ?, clubDescription = ?, clubMentions = ? WHERE clubID = ?');
		$result = $stmt->execute([$clubFunding, $clubMaxStudents, $clubMaxProfessors, $clubLocation, $clubDescription, $clubMentions, $clubID]);
		echo 'Update Successful!';
	}
