<?php
    include('../security_protocols/admin_check_security.php');
    if($_SESSION["permissionsCode"] != 4435 && $_SESSION["permissionsCode"] != 8383) {
        header("Location: ../index.html");
    }
    echo '<div class="input-form-container">
            <div class="table-wrapper">
                    <table id="tabelAdminBasicGeneral">
                        <thead>
                            <tr>
                                <th data-type="text">Course Name</th>
                                <th data-type="text">Exam Count</th>
                                <th data-type="text">Add</th>
                            </tr>
                        </thead>';
        
    $stmt = $pdo->prepare("SELECT courseID, courseName
                            FROM course_general
                            WHERE hasExam = 1;
                        ");
    $stmt->execute();
    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    foreach($stmt->fetchAll() as $row) {
        echo '<tr><td>' . $row['courseName'] . '</td>';
        $count = $pdo->prepare("SELECT courseID FROM exam_general WHERE courseID = ?");
        $count->execute([$row['courseID']]);
        if ($count == NULL) {
            echo '<td>' . '0' . '</td>';
        } else {
            $i = 0;
            foreach($count->fetchAll() as $t) {
                $i++;
            }
            echo '<td>' . $i . '</td>';
        }
        echo '<td><button class="update-button" onclick="openAddExamModal(\'' . $row["courseName"] . '\' , \'' . $row["courseID"] . '\')">Add</button></td>';
        echo "</tr>";
    }
        echo '      </table>
            </div>
        </div>';  
?>