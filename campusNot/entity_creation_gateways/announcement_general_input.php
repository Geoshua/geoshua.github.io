<?php
    include("../security_protocols/user_check_security.php");
	
    $announceID = uniqid();
    $announceDescription = $_POST["announceDescription"];
    $announceRank = $_POST["announceRank"];
    $userID = $_SESSION['userID'];
    $userType = $_SESSION['userType'];
    if ($userType == 'S') {
        $announceRank = min($announceRank, 2);
    }
    if ($userType == 'P') {
        $announceRank = min($announceRank, 8);
    }
    if ($userType == 'A') {
        $announceRank = min($announceRank, 30);
    }
	//inserts to table
    $stmt = $pdo->prepare('INSERT INTO announcement_general (announceID, userID, announceDescription, announceRank) VALUES (?, ?, ?, ?)');
    $result = $stmt->execute([$announceID, $userID, $announceDescription, $announceRank]);
    echo 'Upload Successful!';