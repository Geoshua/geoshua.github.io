<?php
    include("../security_protocols/admin_check_security.php");
    if($_SESSION["permissionsCode"] != 6554 && $_SESSION["permissionsCode"] != 8383) {
        header("Location: ../index.html");
    }
    
    $minOrganisers = $_POST['minOrganisers'];
    $maxOrganisers = $_POST['maxOrganisers'];
    $minMembers = $_POST['minMembers'];
    $maxMembers = $_POST['maxMembers'];

    echo '<div class="input-form-container">
          <button class="back-button" id="filter-buttton" onclick="openFilterModal()">Adjust Filter</button>
          <br>
          <br>
          <br>
            <div class="table-wrapper">
                    <table id="clubUsersTable">
                        <thead>
                            <tr>
                                <th data-type="text">Club</th>
                                <th data-type="text"># Organisers</th>
                                <th data-type="text"># Members</th>
                                <th data-type="text">Club Details</th>
                            </tr>
                        </thead>';
        
    $stmt = $pdo->prepare('SELECT club_general.clubID, clubName, Sum(isOrganiser) AS numOrganisers, Count(userID) AS numMembers
                            FROM club_users
                            INNER JOIN club_general
                            ON club_general.clubID = club_users.clubID

                            GROUP BY club_users.clubID
                            HAVING ( ((Count(userID) >= ?) AND (Sum(isOrganiser) >= ?))
                            AND ((Count(userID) <= IF(? = -1, Count(userID), ?)) AND (Sum(isOrganiser) <= IF(? = -1, Sum(isOrganiser), ?))) );
                        ');
    $stmt->execute([$minMembers, $minOrganisers, $maxMembers, $maxMembers, $maxOrganisers, $maxOrganisers]);
    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    foreach($stmt->fetchAll() as $row) {
        echo '<tr>';
        echo '<td>' . $row['clubName'] . '</td>';
        echo '<td>' . $row['numOrganisers'] . '</td>';
        echo '<td>' . $row['numMembers'] . '</td>';
        echo '<td><button class="update-button" onclick="openClubDetailsModal(\'' . $row["clubID"] . '\')">View</button></td>';
        echo '</tr>';
    }
        echo '      </table>
            </div>
        </div>';
?>