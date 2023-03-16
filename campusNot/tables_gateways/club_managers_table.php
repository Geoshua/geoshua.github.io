<?php
    include("../security_protocols/admin_check_security.php");
    if($_SESSION["permissionsCode"] != 6554 && $_SESSION["permissionsCode"] != 8383) {
        header("Location: ../index.html");
    }

    $relationship = $_POST["relationship"];
    $isOwner = NULL;
    $isOrganiser = NULL;
    if ($relationship == 'A') {
        $isOwner = TRUE;
        $isOrganiser = TRUE;
    } else if ($relationship == 'H') {
        $isOwner = TRUE;
    } else if ($relationship == 'O') {
        $isOrganiser = TRUE;
    }
    $orderBy = $_POST["orderBy"];
    if ($orderBy == 'C') {
        $orderBy = 'clubName';
    } else if ($orderBy == 'S') {
        $orderBy = 'userName';
    } else {
        $orderBy = 'NULL';
    }
    $clubName = $_POST["clubName"];
    $userName = $_POST["userName"];

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
                                <th data-type="text">Student</th>
                                <th data-type="text">Username</th>
                                <th data-type="text">Student Details</th>
                                <th data-type="text">Club Details</th>
                            </tr>
                        </thead>';
        
    $stmt = $pdo->prepare("SELECT clubName, userPersonalName, userName, user_general.userID, club_general.clubID
                            FROM club_general
                            INNER JOIN club_users
                            ON club_general.clubID = club_users.clubID
                            INNER JOIN user_general
                            ON user_general.userID = club_users.userID

                            WHERE clubName = IF (? = '', clubName, ?)
                            AND userName = IF (? = '', userName, ?)
                            AND (isOrganiser = ? OR isOwner = ?)
                            ORDER BY ?;
                        ");
    $stmt->execute([$clubName, $clubName, $userName, $userName, $isOrganiser, $isOwner, $orderBy]);
    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    foreach($stmt->fetchAll() as $row) {
        echo '<tr>';
        echo '<td>' . $row['clubName'] . '</td>';
        echo '<td>' . $row['userPersonalName'] . '</td>';
        echo '<td>' . $row['userName'] . '</td>';
        echo '<td><button class="update-button" onclick="openStudentDetailsModal(\'' . $row["userID"] . '\')">View</button></td>';
        echo '<td><button class="update-button" onclick="openClubDetailsModal(\'' . $row["clubID"] . '\')">View</button></td>';
        echo '</tr>';
    }
        echo '      </table>
            </div>
        </div>';            
?>