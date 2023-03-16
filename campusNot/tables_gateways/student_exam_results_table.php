<?php
    include("../security_protocols/admin_check_security.php");
    if($_SESSION["permissionsCode"] != 1125 && $_SESSION["permissionsCode"] != 8383) {
        header("Location: ../index.html");
    }
    
    $minGrade = $_POST["minGrade"];
    $maxGrade = $_POST["maxGrade"];
    $gradeType = $_POST["gradeType"];
    if ($gradeType == 'P') {
        $minGrade = 4.5;
    } else if ($gradeType == 'F') {
        $maxGrade = 4.499;
    } 
    $orderBy = $_POST["orderBy"];
    if ($orderBy == 'S') {
        $orderBy = 'userPersonalName';
    } else if ($orderBy == 'E') {
        $orderBy = 'examName';
    } else {
        $orderBy = 'examGrade';
    }

    echo '<div class="input-form-container">
          <button class="back-button" id="filter-buttton" onclick="openFilterModal()">Adjust Filter</button>
          <br>
          <br>
          <br>
            <div class="table-wrapper">
                    <table id="studentExamResultsTable">
                        <thead>
                            <tr>
                                <th data-type="text">Name</th>
                                <th data-type="text">Matr No</th>
                                <th data-type="text">Exam</th>
                                <th data-type="text">Grade</th>
                                <th data-type="text">Student Details</th>
                                <th data-type="text">Exam Details</th>
                            </tr>
                        </thead>';
        
    $stmt = $pdo->prepare("SELECT userPersonalName, studentMatrNo, examName, examGrade
                            FROM student_general
                            INNER JOIN  user_general
                            ON user_general.userID = student_general.userID
                            INNER JOIN student_exam_results
                            ON student_general.userID = student_exam_results.userID
                            INNER JOIN  exam_general
                            ON exam_general.examID = student_exam_results.examID
                            
                            WHERE examGrade >= ?
                            AND examGrade <= ?
                            AND examStatus = TRUE
                            ORDER BY ? ASC;
                        ");
    $stmt->execute([$minGrade, $maxGrade, $orderBy]);
    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    foreach($stmt->fetchAll() as $row) {
        echo '<tr><td>' . $row['userPersonalName'] . '</td>';
        echo '<td>' . $row['studentMatrNo'] . '</td>';
        echo '<td>' . $row['examName'] . '</td>';
        echo '<td>' . $row['examGrade'] . '</td>';
        echo '<td><button class="update-button" onclick="openStudentDetailsModal(\'' . $row["userID"] . '\')">View</button></td>';
        echo '<td><button class="update-button" onclick="openExamDetailsModal(\'' . $row["examID"] . '\')">View</button></td>';
        echo '</tr>';
    }
        echo '      </table>
            </div>
        </div>';            
?>