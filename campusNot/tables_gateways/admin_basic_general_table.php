<?php
	include("../security_protocols/admin_master_control.php");
    echo '<div class="input-form-container">
            <div class="table-wrapper">
                    <table id="tabelAdminBasicGeneral">
                        <thead>
                            <tr>
                                <th data-type="text">Admin Name</th>
                                <th data-type="text">Admin User</th>
                                <th data-type="text">Start Year</th>
                                <th data-type="text">End Year</th>
                                <th data-type="text">Permission Code</th>
                                <th data-type="text">Update</th>
                            </tr>
                        </thead>';
        
    $stmt = $pdo->prepare("SELECT user_general.userID, userName, userPersonalName, adminStartYear, adminEndYear, adminPermissionsCode
                            FROM user_general
                            INNER JOIN admin_basic_general
                            ON user_general.userID = admin_basic_general.userID
                            WHERE userType = 'A' AND userStatus = 1;
                        ");
    $stmt->execute();
    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    foreach($stmt->fetchAll() as $row) {
        echo '<tr><td>' . $row['userPersonalName'] . '</td>';
        echo '<td>' . $row['userName'] . '</td>';
        echo '<td>' . $row['adminStartYear'] . '</td>';
        echo '<td>' . $row['adminEndYear'] . '</td>';
        echo '<td>' . $row['adminPermissionsCode'] . '</td>';
        echo '<td><button class="update-button" onclick="openUpdateAdminModal(\'' . $row["userPersonalName"] . '\' , \'' . $row["adminStartYear"] . '\' , \'' . $row["adminEndYear"] . '\' , \'' . $row["adminPermissionsCode"] . '\' , \'' . $row["userID"] . '\')">Update</button></td>';
        echo "</tr>";
    }
        echo '      </table>
            </div>
        </div>';            
?>