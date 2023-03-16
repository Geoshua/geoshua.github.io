<?php
    include("../security_protocols/admin_check_security.php");
    if($_SESSION["permissionsCode"] != 6554 && $_SESSION["permissionsCode"] != 8383) {
        header("Location: ../index.html");
    }
    $userID = $_POST["userID"];

    echo '<div class="input-form-container">';
        
    $stmt = $pdo->prepare("SELECT *
                            FROM student_general
                            INNER JOIN  user_general
                            ON user_general.userID = student_general.userID
                            INNER JOIN  student_details_faculty
                            ON student_details_faculty.userID = student_general.userID
                            INNER JOIN  student_details_personal
                            ON student_details_personal.userID = student_general.userID
                            INNER JOIN  student_details_financial
                            ON student_details_financial.userID = student_general.userID
                            INNER JOIN  student_details_housing
                            ON student_details_housing.userID = student_general.userID
                            INNER JOIN  student_details_health
                            ON student_details_health.userID = student_general.userID
    
                            WHERE user_general.userID = ? AND userType = 'S';
                        ");
    $stmt->execute([$userID]);
    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    foreach($stmt->fetchAll() as $row) {
        echo '<label>Name' . $row['userPersonalName'] . '</label>';
        echo '<label>Username' . $row['userName'] . '</label>';
        echo '<label>Password' . $row['userPassword'] . '</label>';
        echo '<label>Email' . $row['userEmail'] . '</label>';
        echo '<label>User type' . $row['userType'] . '</label>';
        echo '<label>Status' . $row['userStatus'] . '</label>';
        //echo '<label>' . $row['status_registration'] . '</label>';
        //echo '<label>Name' . $row['status_finish_course'] . '</label>';
        echo '<label>Is TA' . $row['isTA'] . '</label>';
        echo '<label>In Club' . $row['inClub'] . '</label>';
        echo '<label>In CO' . $row['inCO'] . '</label>';
        echo '<label>Lives on Campus' . $row['livesCampus'] . '</label>';
        echo '<label>Undergrad' . $row['isUndergrad'] . '</label>';
        echo '<label>Masters' . $row['isMasters'] . '</label>';
        echo '<label>PhD' . $row['isPhD'] . '</label>';
        echo '<label>Thesis Status' . $row['thesis_status'] . '</label>';
        echo '<label>Account Balance' . $row['studentRemainingAcc'] . '</label>';
        echo '<label>Took StudyAtEase' . $row['studentStudyAtEase'] . '</label>';
        echo '<label>Housing Paid' . $row['studentHousingPaid'] . '</label>';
        echo '<label>Tuition Paid' . $row['studentTuitionPaid'] . '</label>';
        echo '<label>Fees Paid' . $row['studentFeesPaid'] . '</label>';
        echo '<label>Housing Balance' . $row['studentHousingAmmount'] . '</label>';
        echo '<label>Tuition Balance' . $row['studentTuitionAmmount'] . '</label>';
        echo '<label>Fees Balance' . $row['studentFeesAmmount'] . '</label>';
        echo '<label>Invoice' . $row['studentInvoice'] . '</label>';
        echo '<label>Insurance' . $row['hasHealthInsurance'] . '</label>';
        echo '<label>Insurance Scan' . $row['healthInsuranceScan'] . '</label>';
        echo '<label>College' . $row['studentCollege'] . '</label>';
        echo '<label>Room' . $row['studentRoom'] . '</label>';
        echo '<label>On Mealplan' . $row['isOnMealplan'] . '</label>';
        echo '<label>Kitchen Access' . $row['hasKitchenAccess'] . '</label>';
        echo '<label>Preferred Name' . $row['studentPreferredName'] . '</label>';
        echo '<label>Gender' . $row['studentGender'] . '</label>';
        echo '<label>Religion' . $row['studentReligion'] . '</label>';
        echo '<label>Nationality' . $row['studentNationality'] . '</label>';
        echo '<label>Language' . $row['studentLanguage'] . '</label>';
        echo '<label>Age' . $row['studentAge'] . '</label>';
        echo '<label>Mentions' . $row['studentMentions'] . '</label>';
        echo '<label>Matr Number' . $row['studentMatrNo'] . '</label>';
        echo '<label>Start Year' . $row['studentYearStart'] . '</label>';
        echo '<label>End Year' . $row['studentYearEnd'] . '</label>';
        echo '<label>Major 1' . $row['studentMajorOne'] . '</label>';
        echo '<label>Major 2' . $row['studentMajorTwo'] . '</label>';
        echo '<label>Email (Personal)' . $row['studentEmailPersonal'] . '</label>';
        //for the record, I hated doing this
    }
        echo '</div>'; 

?>