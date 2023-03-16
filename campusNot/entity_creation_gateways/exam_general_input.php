<?php
	include('../security_protocols/admin_check_security.php');
    if($_SESSION["permissionsCode"] != 4435 && $_SESSION["permissionsCode"] != 8383) {
        header("Location: ../index.html");
    }
	$examID = uniqid();
	$examName = $_POST["examName"];
	$courseID = $_POST["courseID"];
	$examAttemptNum = $_POST["examAttempt"];
	$examTimeStart = $_POST["examTimeStart"];
	$examTimeEnd = $_POST["examTimeEnd"];
	$examDate = $_POST["examDate"];
	$examLocation = $_POST["examLocation"];
	$examMentions = $_POST["examMentions"];
    $examStatus = 1;

	//check if course exists
	$stmt = $pdo->prepare("SELECT * FROM course_general WHERE courseID = ?");
	$stmt->execute([$courseID]);
	$check = $stmt->fetch();
	
	//inserts to exam_general
	if ($check == NULL) {
		echo 'This course doesn\'t exist!';
	} else {
		$stmt = $pdo->prepare('INSERT INTO exam_general (examID, courseID, examName, examStatus) VALUES (?, ?, ?, ?)');
		$result = $stmt->execute([$examID, $courseID, $examName, $examStatus]);
		$stmt = $pdo->prepare('INSERT INTO exam_details (examID, examTimeStart, examTimeEnd, examLocation, examComment, examDate, examAttemptNum) VALUES (?, ?, ?, ?, ?, ?, ?)');
		$result = $stmt->execute([$examID, $examTimeStart, $examTimeEnd, $examLocation, $examMentions, $examDate, $examAttemptNum]);
		echo 'Exam Upload Successful!';
	}
