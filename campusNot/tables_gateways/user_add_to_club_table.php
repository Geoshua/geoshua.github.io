<?php
    include("../security_protocols/admin_check_security.php");
    if($_SESSION["permissionsCode"] != 6554 && $_SESSION["permissionsCode"] != 8383) {
        header("Location: ../index.html");
    }

    $clubID = $_POST["clubID"];
    echo '<div class="input-form-container">
            <div class="table-wrapper">
                    <table id="clubUsersTable">
                        <thead>
                            <tr>
                                <th data-type="text">Name</th>
                                <th data-type="text">User</th>
                                <th data-type="text">Type</th>
                                <th data-type="text">Add</th>
                            </tr>
                        </thead>';
        
    $stmt = $pdo->prepare('SELECT userID, userName, userPersonalName, userType
                           FROM user_general 
                           WHERE userID NOT IN (SELECT userID FROM club_users WHERE clubID=?) AND userType != "A"
                           ORDER BY userName ASC, userType DESC
                        ');
    $stmt->execute([$clubID]);
    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    foreach($stmt->fetchAll() as $row) {
        echo '<tr>';
        echo '<td>' . $row['userPersonalName'] . '</td>';
        echo '<td>' . $row['userName'] . '</td>';
        echo '<td>' . $row['userType'] . '</td>';
        echo '<td><button class="update-button" onclick="addClubUser(\'' . $row["userID"] . '\' , \'' . $clubID . '\')">Add</button></td>';
        echo '</tr>';
    }
    $stmt = $pdo->prepare('SELECT user_general.userID, userName, userPersonalName, userType
                            FROM user_general 
                            INNER JOIN club_users
                            ON user_general.userID = club_users.userID
                            WHERE clubID=? AND userType != "A"
                            ORDER BY userName ASC, userType DESC
                        ');
    $stmt->execute([$clubID]);
    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    foreach($stmt->fetchAll() as $row) {
    echo '<tr>';
    echo '<td>' . $row['userPersonalName'] . '</td>';
    echo '<td>' . $row['userName'] . '</td>';
    echo '<td>' . $row['userType'] . '</td>';
    echo '<td><button class="update-button" onclick="removeClubUser(\'' . $row["userID"] . '\' , \'' . $clubID . '\')">Delete</button></td>';
    echo '</tr>';
    }

        echo '      </table>
            </div>
            <br><br>
        </div>';            
?>