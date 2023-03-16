<?php
    include("../security_protocols/admin_check_security.php");
    if($_SESSION["permissionsCode"] != 6554 && $_SESSION["permissionsCode"] != 8383) {
        header("Location: ../index.html");
    }

    echo '<div class="input-form-container">
            <div class="table-wrapper">
                    <table id="clubUsersTable">
                        <thead>
                            <tr>
                                <th data-type="text">Club</th>
                                <th data-type="text">Students</th>
                                <th data-type="text">Professors</th>
                                <th data-type="text">Add Participant</th>
                            </tr>
                        </thead>';
        
    $stmt = $pdo->prepare("SELECT club_general.clubID, clubName, clubRegistrationsStudents, clubRegistrationProfessors, clubMaxStudents, clubMaxProfessors
                            FROM club_general
                            INNER JOIN club_details
                            ON club_general.clubID = club_details.clubID
                            WHERE clubStatus = 1
                            ORDER BY clubName;
                        ");
    $stmt->execute([]);
    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    foreach($stmt->fetchAll() as $row) {
        echo '<tr>';
        echo '<td>' . $row['clubName'] . '</td>';
        echo '<td>' . $row['clubRegistrationsStudents'] . '/' . $row['clubMaxStudents'] . '</td>';
        echo '<td>' . $row['clubRegistrationProfessors'] . '/' . $row['clubMaxProfessors'] . '</td>';
        echo '<td><button class="update-button" onclick="openAddClubUserModal(\'' . $row["clubID"] . '\' , \'' . $row["clubName"] . '\')">Add</button></td>';
        echo '</tr>';
    }
        echo '      </table>
            </div>
        </div>';            
?>