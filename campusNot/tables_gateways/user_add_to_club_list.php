<?php
    include("../db.php");
    /*include("../security_protocols/admin_check_security.php");
    if($_SESSION["permissionsCode"] != 6554 && $_SESSION["permissionsCode"] != 8383) {
        header("Location: ../index.html");
    }
 
    $userList = array();
    $stmt = $pdo->prepare('SELECT userID, userName, userPersonalName, userType
                           FROM user_general 
                           WHERE userID NOT IN (SELECT userID FROM club_users WHERE clubID=?) AND userType != "A"
                           ORDER BY userName ASC, userType DESC
                        ');
    $stmt->execute([$clubID]);
    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    foreach($stmt->fetchAll() as $row) {
        array_push($userList, $row['userPersonalName']);
    }          
    echo json_encode($userList);*/
    $connect = mysqli_connect($host, $user, $pass, $db);
    $clubID = $_POST["clubID"];  
    if(isset($_POST["userName"]))  {  
        $output = '';  
        /*$query = "SELECT userID FROM club_users WHERE clubID = $clubID";
        $restr = mysqli_query($connect, $query);
        if(mysqli_num_rows($result) > 0)  {
            $restr = mysqli_fetch_array($restr);
        } else {
            $restr = array([]);
        }*/
        $query = "SELECT * FROM user_general WHERE userName LIKE '%".$_POST["userName"]."%'";  
        $result = mysqli_query($connect, $query);  
        $output = '<ul class="list-unstyled">';  
        if(mysqli_num_rows($result) > 0)  {  
            while($row = mysqli_fetch_array($result))  {  
                    $output .= '<li>'.$row["userName"].'</li>';  
            }  
        }  
        else  {  
            $output .= '<li>User Not Found</li>';  
        }  
        $output .= '</ul>';  
        echo $output;  
    }  
?>