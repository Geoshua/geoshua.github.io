<?php
    include("../security_protocols/admin_check_security.php");
    if($_SESSION["permissionsCode"] != 1125 && $_SESSION["permissionsCode"] != 8383) {
        header("Location: ../index.html");
    }
    
    $examID = $_POST["examID"];

    echo '<div class="input-form-container">';
        
    $stmt = $pdo->prepare("SELECT examName, examStatus, examAttemptNum, examDate, examTimeStart, examTimeEnd, examLocation, examComment
                            FROM exam_general
                            INNER JOIN  exam_details
                            ON exam_general.examID = exam_details.examID
                            
                            WHERE examID = ?;
                        ");
    $stmt->execute([$examID]);
    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    foreach($stmt->fetchAll() as $row) {
        echo '<label>Name' . $row['examName'] . '</label>';
        echo '<label>Attempt' . $row['examAttemptNum'] . '</label>';
        echo '<label>Date' . $row['examDate'] . '</label>';
        echo '<label>Start' . $row['examTimeStart'] . '</label>';
        echo '<label>End' . $row['examTimeEnd'] . '</label>';
        echo '<label>Location' . $row['examLocation'] . '</label>';
        echo '<label>Comment' . $row['examComment'] . '</label>';
        echo '<label>Status' . $row['examStatus'] . '</label>';
    }
        echo '</div>';            
?>