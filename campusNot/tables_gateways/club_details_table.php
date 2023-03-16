<?php
    include("../security_protocols/admin_check_security.php");
    if($_SESSION["permissionsCode"] != 6554 && $_SESSION["permissionsCode"] != 8383) {
        header("Location: ../index.html");
    }
    echo '<div class="input-form-container">
            <div class="table-wrapper">
                    <table id="tabelAdminBasicGeneral">
                        <thead>
                            <tr>
                                <th data-type="text">Club Name</th>
                                <th data-type="text">Club Funding</th>
                                <th data-type="text">Students</th>
                                <th data-type="text">Max Student</th>
                                <th data-type="text">Professors</th>
                                <th data-type="text">Max Professor</th>
                                <th data-type="text">Location</th>
                                <th data-type="text">Description</th>
                                <th data-type="text">Mentions</th>
                                <th data-type="text">Update</th>
                            </tr>
                        </thead>';
        
    $stmt = $pdo->prepare("SELECT club_general.clubID, clubName, clubFunding, clubRegistrationsStudents, clubMaxStudents, clubRegistrationProfessors, clubMaxProfessors, clubLocation, clubDescription, clubMentions
                            FROM club_general
                            INNER JOIN club_details
                            ON club_general.clubID = club_details.clubID
                            WHERE clubStatus = 1;
                        ");
    $stmt->execute();
    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    foreach($stmt->fetchAll() as $row) {
        echo '<tr><td>' . $row['clubName'] . '</td>';
        echo '<td>' . $row['clubFunding'] . '</td>';
        echo '<td>' . $row['clubRegistrationsStudents'] . '</td>';
        echo '<td>' . $row['clubMaxStudents'] . '</td>';
        echo '<td>' . $row['clubRegistrationProfessors'] . '</td>';
        echo '<td>' . $row['clubMaxProfessors'] . '</td>';
        echo '<td>' . $row['clubLocation'] . '</td>';
        echo '<td><button class="update-button" onclick="openClubDescriptionModal(\'' . $row['clubDescription'] . '\')">View</button></td>';
        echo '<td><button class="update-button" onclick="openClubMentionsModal(\'' . $row['clubMentions'] . '\')">View</button></td>';
        echo '<td><button class="update-button" onclick="openUpdateClubModal(\'' . $row["clubName"] . '\' , \'' . $row["clubFunding"] . '\' , \'' . $row["clubMaxStudents"] . '\' , \'' . $row["clubMaxProfessors"] . '\', \'' . $row["clubLocation"] . '\', \'' . $row["clubDescription"] . '\' , \'' . $row["clubMentions"] . '\' ,  \'' . $row["clubID"] . '\')">Update</button></td>';
        echo "</tr>";
    }
        echo '      </table>
            </div>
        </div>';            
?>