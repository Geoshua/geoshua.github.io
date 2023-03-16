<?php
    include("../security_protocols/admin_check_security.php");
    if($_SESSION["permissionsCode"] != 6554 && $_SESSION["permissionsCode"] != 8383) {
        header("Location: ../index.html");
    }
    $clubID = $_POST["clubID"];

    echo '<div class="input-form-container">';
        
    $stmt = $pdo->prepare("SELECT *
                            FROM club_general
                            INNER JOIN  club_details
                            ON club_details.clubID = club_general.clubID
                            INNER JOIN  club_schedule
                            ON club_schedule.clubID = club_general.clubID

    
                            WHERE club_general.clubID = ?;
                        ");
    $stmt->execute([$clubID]);
    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    foreach($stmt->fetchAll() as $row) {
       // echo $clubID;
        echo '<label>Name' . $row['clubName'] . '</label>';
        echo '<label>Status' . $row['clubStatus'] . '</label>';
        echo '<label>Funding' . $row['clubFunding'] . '</label>';
        echo '<label>Registered Students' . $row['clubRegistrationsStudents'] . '</label>';
        echo '<label>Max Studetnts' . $row['clubMaxStudents'] . '</label>';
        echo '<label>Registered Professors' . $row['clubRegistrationProfessors'] . '</label>';
        echo '<label>Max Professors' . $row['clubMaxProfessors'] . '</label>';
        echo '<label>Location' . $row['clubLocation'] . '</label>';
        echo '<label>Description' . $row['clubDescription'] . '</label>';
        echo '<label>Mentions' . $row['clubMentions'] . '</label>';
        echo '<label>Start Date' . $row['clubStartdate'] . '</label>';
        echo '<label>End Date' . $row['clubEnddate'] . '</label>';
        echo '<label>Day One' . $row['clubDayOne'] . '</label>';
        echo '<label>Day Two' . $row['clubDayTwo'] . '</label>';
        echo '<label>Day Three' . $row['clubDayThree'] . '</label>';
        echo '<label>Timeslot One' . $row['clubTimeSlotOne'] . '</label>';
        echo '<label>Timeslot Two' . $row['clubTimeSlotTwo'] . '</label>';
        echo '<label>Timeslot Three' . $row['clubTimeSlotThree'] . '</label>';
        echo '<label>Duration One' . $row['clubDurationOne'] . '</label>';
        echo '<label>Duration Two' . $row['clubDurationTwo'] . '</label>';
        echo '<label>Duration Three' . $row['clubDurationThree'] . '</label>';
        //for the record, I hated doing this
        //me too
    }
        echo '</div>'; 

?>