<?php
    include("../security_protocols/admin_check_security.php");
    if($_SESSION["permissionsCode"] != 4435 && $_SESSION["permissionsCode"] != 8383) {
        header("Location: ../index.html");
    }

	$courseID = uniqid();
	$courseName = $_POST["courseName"];
    $hasExam = strval($_POST["hasExam"]);
    $hasTutorial = strval($_POST["hasTutorial"]);
    $hasLab = strval($_POST["hasLab"]);
    $courseStatus = 1;

	//inserts to course_general
	$stmt = $pdo->prepare('INSERT INTO course_general (courseID, courseName, hasExam, hasLab, hasTutorial, courseStatus) VALUES (?, ?, ?, ?, ?, ?)');
	$result = $stmt->execute([$courseID, $courseName, $hasExam, $hasLab, $hasTutorial, $courseStatus]);
	$stmt = $pdo->prepare('INSERT INTO course_details (courseID, courseCredits) VALUES (?, 0)');
	$result = $stmt->execute([$courseID]);
	echo 'Upload Successful!';
